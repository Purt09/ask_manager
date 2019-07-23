<?php

namespace app\modules\task\components;

use Yii;
use yii\base\Widget;
use app\modules\project\models\Project;
use app\modules\task\forms\CreateForm;
use app\modules\user\models\User;

class CreateTaskWidget extends Widget
{

    /**
     * @var Project object определяет к какому проекту относится задача
     */
    public $project;

    /**
     * @var array objects Подпроекты для выбора проекта
     */
    public $projects;


    public function run()
    {
        // Нормализует вид
        $this->projects = array_column($this->projects, 'title', 'id');

        $model = new CreateForm();
        $model->project_id = $this->project->id;

        if ($model->load(Yii::$app->request->post()) ) {
            $model->save();
            Yii::$app->response->refresh();
        }


        return $this->render('createTaskWidget', [
            'model' => $model,
            'project_id' => $this->project->id,
            'projects' => $this->projects
        ]);
    }


}