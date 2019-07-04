<?php

namespace app\modules\project\models;

use Yii;
use app\modules\task\models\Task;
use app\modules\project\Module;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property int $id
 * @property int $time_at
 * @property string $title
 * @property string $description
 * @property int $parent_id
 *
 * @property Project $parent
 * @property Project[] $projects
 * @property Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [ 'title', 'required'],
            [['time_at', 'parent_id'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time_at' => Module::t('module', 'TIME_END_AT'),
            'title' => Module::t('module', 'PROJECT_TITLE'),
            'description' => Module::t('module', 'PROJECT_DESCRIPTION'),
            'parent_id' => Module::t('module', 'PROJECT_PARENT'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Project::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }

    /**
     * @param $id
     * @return Project|null
     */
    public function getTitle($id){
        $model = Project::findOne($id);
        return $model->title;
    }

    /**
     * Возращает задачи определенных проектов по умолчанию еще не выполненные
     * @param $projects
     * @return mixed
     */
    public function getTasksByProjects($projects, $status = 1){

        $id =[];
        foreach ($projects as $project) array_push($id, $project->id);
        foreach ($id as $i) {
            $t = Task::find()->where(['project_id' => $i, 'status' => $status])->select(['title', 'id'])->all();
            $task[$i] = $t;
        }
        return $task;
    }

    /**
     * @param null $parent_id
     * @return mixed
     */
    public function getProjectByParent_id($parent_id = NULL) {
        return $projects = User::find()->where(['id' => Yii::$app->user->identity->id])->one()->getProjects()->with('projects')->where(['parent_id' => $parent_id])->all(); // Сложный запрос, связь многие ко многим
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (Yii::$app->request->post()) {
            $user = User::findOne(\Yii::$app->user->identity->id);
            $project = Project::find()->where(['id' => $this->id])->one();

            $project->link('projects', $user);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * connects many to many with users
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('{{%user_project}}', ['project_id' => 'id']);
    }

}
