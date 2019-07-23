<?php


namespace app\modules\task\components;

use Yii;
use yii\base\Widget;

class TasksListWidget extends Widget
{
    /**
     * @var array все задачи для вывода
     */
    public $tasks;
    /**
     * @var int определяет с каким статусом надо вывести задачи
     */
    public $status;


    public function run()
    {
        return $this->render('tasksListWidget', [
            'tasks' => $this->tasks,
            'status' => $this->status,
        ]);
    }
}