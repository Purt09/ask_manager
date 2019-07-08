<?php

namespace app\modules\task\components;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use app\modules\task\forms\CreateForm;
use app\modules\user\models\User;

class CreateTaskWidjet extends Widget
{

    /**
     * @var object определяет к какому проекту относится задача
     */
    public $project;

    /**
     * @var array objects Подпроекты для генерации
     */
    public $projects;


    public function run()
    {
        $model = new CreateForm();
        $model->project_id = $this->project->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->response->refresh();
        }

        if(empty($this->projects)) {
            $this->projects = User::find()->where(['id' => Yii::$app->user->identity->id])->one()->getProjects()->with('projects')->select('title')->indexBy('id')->column(); // Сложный запрос, связь многие ко многим
        } else {
            $this->projects = ArrayHelper::getColumn($this->projects, 'title');
            $this->projects += array(
                $this->project->id => $this->project->title,
            );
        }

        return $this->render('createTaskWidjet',            [
            'model' => $model,
            'project_id' => $this->project->id,
            'projects' => $this->projects
             ]);
    }


}