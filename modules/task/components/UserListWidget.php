<?php


namespace app\modules\task\components;

use Yii;
use yii\base\Widget;

class UserListWidget extends Widget
{
    public $tasks;

    public $status;

    public $redirect;


    public function run()
    {
        return $this->render('userListWidget', [
            'tasks' => $this->tasks,
            'status' => $this->status,
            'redirect' => $this->redirect,
        ]);
    }
}