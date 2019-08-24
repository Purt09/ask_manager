<?php


namespace app\modules\task\components;

use app\modules\user\models\User;
use app\modules\project\models\Project;
use app\components\TimeSupport;
use app\modules\task\models\Task;
use Yii;
use yii\base\Widget;


/**
 * Выводит список задач
 *
 * Class TasksListWidget
 * @package app\modules\task\components
 */
class TasksListWidget extends Widget
{
    /*
     * Определяет шаблон
     */
    public $tpl = 'tasksListWidget';
    /**
     * @var array все задачи для вывода
     */
    public $tasks = null;
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


    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        if($this->tasks === null){
            $task = new Task();
            $user = User::findOne(Yii::$app->user->id);
            $this->tasks = $task->getTasksFromProjects($this->project, $user);

        }
        $this->tasks = $this->sort($this->tasks);
//        TimeSupport::changeStatus($this->tasks);

//        foreach ($this->tasks as $task){
//            if ($task['updated_at'] != null)
////                $task['updated_at'] = TimeSupport::createtime($task['updated_at']);
//        }




        return $this->render($this->tpl, [
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