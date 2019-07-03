<?php

namespace app\modules\task\models;

use app\modules\project\models\Project;
use app\modules\task\Module;
use app\modules\user\models\User;
use Yii;
use app\components\TimeSupport;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property string $title
 * @property string $description
 * @property int $project_id
 * @property int $context_id
 * @property int $user_id
 * @property int $status
 */
class Task extends \yii\db\ActiveRecord
{
    const STATUS_COMPLETE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_TIME_OUT = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'string', 'min' => 3, 'max' => 60, 'message' => 'Слишком короткое'],

            [['created_at', 'project_id', 'context_id', 'user_id', 'status', 'updated_at'], 'integer'],



            ['description', 'string', 'max' => 255],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Module::t('module', 'TASK_CREATE_AT'),
            'updated_at' => Module::t('module', 'TASK_UPDATE_AT'),
            'title' => Module::t('module', 'TASK_TITLE'),
            'description' => Module::t('module', 'TASK_DESCRIPTION'),
            'status' => Module::t('module', 'TASK_STATUS'),
            'project_id' => Module::t('module', 'PROJECT'),
        ];
    }

    /**
     * get status name
     *
     * @return mixed
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    /**
     * name status
     *
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_COMPLETE => Module::t('module', 'TASK_STATUS_CAR'),
            self::STATUS_ACTIVE => Module::t('module', 'TASK_STATUS_ACTIVE'),
            self::STATUS_TIME_OUT => Module::t('module', 'TASK_STATUS_TIME_OUT'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * getting id tasks
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * {@inheritdoc}
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    /**
     * Change status task
     * @param $id
     */
    public function setStatus($status = self::STATUS_COMPLETE){
        $this->status = $status;
        $this->update();
    }

    /**
     * Возвращает задачи по статусу
     *  1 - активные
     *  2 - просроченные
     *  0 - выполенные
     * @param int $status
     * @return Task[]|array
     */
    public function getTasks($status = self::STATUS_COMPLETE){
        $tasks = User::find()->where(['id' => Yii::$app->user->identity->id])->one()->getTasks()->where(['status' => $status])->with('users')->asArray()->all(); // Сложный запрос, связь многие ко многим
        TimeSupport::changeStatus($tasks);
        return $tasks;
    }

    /**
     * Возращает массив хадач определенного проекта с определенным статусом
     *
     * @param $project_id
     * @param $status
     * @return Task[]|array
     */
    public function getTasksByProject($project_id, $status = 1, $count = false){
        if (!$count){
            $tasks = User::find()->where(['id' => Yii::$app->user->identity->id])->one()->getTasks()->where(['project_id' => $project_id, 'status' => $status])->asArray()->all();  // Сложный запрос, связь многие ко многим
            TimeSupport::changeStatus($tasks);
            return $tasks;
        }
            else
                return $tasks = User::find()->one()->getTasks()->where(['project_id' => $project_id, 'status' => $status])->count();
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('{{%user_task}}', ['task_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (Yii::$app->request->post()) {
            $user = User::findOne(\Yii::$app->user->identity->id);
            $task = Task::find()->where(['id' => $this->id])->one();

            $task->link('users', $user);
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
