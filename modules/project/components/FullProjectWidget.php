<?php

namespace app\modules\project\components;

use app\modules\project\models\Project;
use app\modules\user\models\User;
use app\components\TimeSupport;
use Yii;
use app\modules\task\models\Task;
use yii\helpers\ArrayHelper;
use yii\base\Widget;

/**
 * Виджет выводит все проеты и задачи к ним.
 *
 * Внимание нельзя использовать проекты с id  0 1 2 3
 * Они зарезервированы под глобальные
 *
 * Class FullProjectWidget
 * @package app\modules\project\components
 */
class FullProjectWidget extends Widget
{
    public $users;

    public $tasks = null;

    public $project = null;

    public $projects = [];


    public function run()
    {

        if ($this->tasks == null)
            $this->tasks = $this->getTasks($this->projects);
        $colortasks = $this->getColorTasks($this->tasks);


        TimeSupport::changeStatus($this->tasks);

        foreach ($this->tasks as $task)
            if ($task['updated_at'] != null)
                $task['updated_at'] = TimeSupport::createtime($task['updated_at']);


        return $this->render('fullProjectWidget', [
            'projects' => $this->projects,
            'project' => $this->project,
            'tasks' => $this->tasks,
            'colortasks' => $colortasks,
            'users' => $this->users,
            'time' => time(),

        ]);
    }

    /*
     * Формирует цвет кнопки в виджете, при клтике на котрую задача выполняется
     */
    public function getColorTasks($tasks)
    {
        $colortasks = [];
        foreach ($tasks as $task) {
            if ($task['user_id'] == Yii::$app->user->id)
                $colortasks[$task['id']] = 'info';
            else
                $colortasks[$task['id']] = 'warning';

            if ($task['user_id'] == null)
                $colortasks[$task['id']] = 'success';
            if($task['status'] == 0 )
                $colortasks[$task['id']] = 'primary';
            if($task['status'] == 2)
                $colortasks[$task['id']] = 'danger';
        }
        return $colortasks;
    }

    /**
     * Возвращяает все задачи определенных проектов
     *
     * @param $projects
     * @return array|\yii\db\ActiveRecord[]
     * @throws \yii\base\InvalidConfigException
     */
    public function getTasks($projects)
    {
        $task = new Task();
        $user = User::findOne(Yii::$app->user->id);

        return $task->getTasksFromProjects($projects, $user);
    }
}