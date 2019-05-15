<?php

namespace app\modules\project\controllers;

use app\modules\project\models\Project;
use app\modules\task\models\Task;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new Project();
        $projects = $model->getProjectByParent_id();
        $task = $model->getTaskByProjects($projects);


        return $this->render('index', [
            'projects' => $projects,
            'task' => $task

        ]);
    }

}
