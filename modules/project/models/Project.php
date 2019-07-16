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
 * @property int $creator_id
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

    /**Возращает проекты опрделённого родителя
     * asArray надо для виджета вывода проекта с подпроектами
     * @param null $parent_id
     * @return mixed
     */
    public function getProjectByParent_id($parent_id) {
        return $projects = User::find()->where(['id' => Yii::$app->user->identity->id])->one()->getProjects()->with('projects')->where(['parent_id' => $parent_id])->indexBy('id')->asArray()->all(); // Сложный запрос, связь многие ко многим
    }



    /**
     * Сохраняет данные, со связью многие ко многим
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (Yii::$app->request->post()) {
            $user = User::findOne(\Yii::$app->user->identity->id);
            $project = Project::find()->where(['id' => $this->id])->one();

            $project->link('users', $user);
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


    public function setLeader($user_id,Project $project){
        $project->creator_id = $user_id;
        return $project->save();
    }

    public function getSubprojectsByProject(Project $project){
        $projects = array($project);

        $all_projects = Project::find()->all();
        foreach ($all_projects as $p) {
            if ($p->parent_id == $project->id) {
                array_push($projects, $p);
            }
        }
        return $projects;

    }

}
