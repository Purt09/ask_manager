<?php

namespace app\modules\project\models;

use Yii;
use app\modules\task\models\Task;
use app\modules\project\Module;
use yii\data\ActiveDataProvider;

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
     * Возращает проеты по определенному parent_id
     * @param null $parent_id
     * @return Project[]|array
     */
    public function getProjectByParent_id($parent_id = NULL) {
        return $projects = Project::find()->where(['parent_id' => $parent_id])->all();
    }

    /**
     * Возращает массив хадач определенного проекта с определенным статусом
     *
     * @param $project_id
     * @param $status
     * @return Task[]|array
     */
    public function getTasksByProject($project_id, $status = 1){

            return $task = Task::find()->where(['project_id' => $project_id, 'status' => $status])->asArray()->indexBy('id')->all();


    }
}
