<?php

namespace app\modules\project\controllers;


use app\modules\project\models\Project;

use app\modules\user\models\chat\Chat;

class AjaxController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if(\Yii::$app->request->isAjax) {
            return true;
        }
        else {
            return $this->redirect('/project/ajax/index');
        }
        return parent::beforeAction($action);
    }

    public function actionAddProject($title, $time_at, $description, $parent_id){
        $project = new Project();
        $project->title = $title;
        $project->time_at = $time_at;
        $project->description = $description;
        $project->parent_id = $parent_id;
        $project->save();
    }

    public function actionDeleteProject($project_id){
        $project = Project::findOne($project_id);

        $chat = Chat::findOne($project->chat_id);
        $chat->addMessage('Проект "' . $project->title . '" был закрыт');

        $project->delete();
    }

}