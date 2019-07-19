<?php


namespace app\modules\task\components;

use Yii;
use yii\base\Widget;

class TasksListWidget extends Widget
{
    public $tasks;

    public $status;

    public $redirect;

    public $complete = 'complete';


    public function run()
    {
        return $this->render('tasksListWidget', [
            'tasks' => $this->tasks,
            'status' => $this->status,
            'redirect' => $this->redirect,
            'complete' => $this->complete,
        ]);
    }
}