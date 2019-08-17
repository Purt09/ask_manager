<?php

namespace app\modules\task\models;

use app\modules\project\models\Project;
use app\modules\task\Module;
use app\modules\user\models\connections\ProjectUser;
use app\modules\user\models\connections\TaskUser;
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
 * @property string $first_name
 * @property string $last_name
 * @property string $photo
 * @property string $photo_medium
 * @property string $photo_big
 * @property int phone
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
     * Меняет статус задачи
     *
     * @param int $status
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function setStatus($status = self::STATUS_COMPLETE){
        $this->status = $status;
        $this->update();
    }

    /**
     * Возвращает все задачи пользователя
     *
     * Проверяет вышло ли время на выполнение этой задачи
     *
     * @param User $user
     * @return array|ActiveRecord[]
     * @throws \yii\base\InvalidConfigException
     */
    public function getTasks(User $user){
        $tasks = $user->getTasks()->all();
        TimeSupport::changeStatus($tasks); // Проверка статуса задачи
        return $tasks;
    }

    /**
     * Возвращает все задачи всех $projects определенного $user
     *
     * @param array $projects
     * @param User $user
     * @return array|ActiveRecord[]
     * @throws \yii\base\InvalidConfigException
     */
    public function getTasksFromProjects(array $projects, User $user){
        $ids = array_keys($projects);
        return $user->getTasks()->where(['in', 'project_id', $ids])->all();
    }

    /**
     * Добавляет пользователя во все задачи проетов $projects
     *
     * @param User $user
     * @param array $projects
     * @throws \yii\base\InvalidConfigException
     */
    public function setUserInTasks(User $user, array $projects){
        $task = new Task();
        $userCreator = User::findOne(Yii::$app->user->identity->id);
        $tasks = $task->getTasksFromProjects($projects, $userCreator);
        // Связываем нового пользователя и задачи
        foreach ($tasks as $t)
            $t->link('users', $user);

    }

    /**
     * connects many to many with users
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('{{%user_task}}', ['task_id' => 'id']);
    }

    public function delUser(array $projects, User $user){
        $tasks = Task::getTasksFromProjects($projects, $user);
        foreach ($tasks as $t)
            TaskUser::deleteAll(['task_id' => $t->id, 'user_id' => $user->id]);
    }

    /*
     * Сохраняет для всех пользователдей задачу, которые есть в данной категории!
     */
    public function afterSave($insert, $changedAttributes)
    {
            $task = Task::find()->where(['id' => $this->id])->one();

            if($task->project_id != null) {
                $userProjects = ProjectUser::find()->where(['project_id' => $task->project_id])->all();
                $userIds = array();
                foreach ($userProjects as $userProject) {
                    array_push($userIds, $userProject->user_id);
                }
                $users = User::find()->where(['in', 'id', $userIds])->all();
                foreach ($users as $u)
                    $task->link('users', $u);
            }
        parent::afterSave($insert, $changedAttributes);
    }
}
