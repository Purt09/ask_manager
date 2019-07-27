<?php


namespace app\modules\task\components;

use app\modules\admin\models\User;
use app\modules\project\models\Project;
use Yii;
use yii\base\Widget;
use app\components\TimeSupport;

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
    /**
     * @var array User пользователи, которые участвуют в разработке
     */
    public $users;
    /**
     * @var Project Категория в которой находится проект.
     */
    public $project;
    /**
     * @var Определяет цвет всех кнопок
     */
    public $color_toggle = null;



    public function run()
    {
        $this->tasks = $this->sort($this->tasks);
        TimeSupport::changeStatus($this->tasks);

        return $this->render('tasksListWidget', [
            'tasks' => $this->tasks,
            'status' => $this->status,
            'users' => $this->users,
            'color_toggle' => $this->color_toggle,
            'project' => $this->project,
        ]);
    }

    /** Сортирует по принципу, сначала личные, потом общие, потом чужие.
     *
     * Дополнителбно формирует цвета у кнопок
     *
     * @param $tasks
     * @return mixed
     */
    public function sort($tasks)
    {
        $sortTasks = [];
        $idsUser = [];

        foreach ($tasks as $task)
            if ($task['user_id'] == Yii::$app->user->id) {
                $sortTasks += array($task['id'] => $task);
                $this->color_toggle[$task['id']] = 'info';
            }
        foreach ($tasks as $task)
            if ($task['user_id'] == null) {
                $sortTasks += array($task['id'] => $task);
                $this->color_toggle[$task['id']] = 'success';
            }
        foreach ($tasks as $task)
            if (($task['user_id'] != null) && ($task['user_id'] != Yii::$app->user->id)) {
                $sortTasks += array($task['id'] => $task);
                $this->color_toggle[$task['id']] = 'warning';
                $idsUser += array($task['id'] => $task['user_id']);
            }



        return $sortTasks;
    }
}