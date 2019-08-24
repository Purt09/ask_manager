<?php

namespace app\modules\task\components;

use yii\base\Widget;
use app\modules\task\models\Task;

/**
 * Виджет-кнопка при клике на которую выводится случайная задача
 * Можно также вывести случайный проект, если в переменную tasks отправить массив проектов
 *
 * Class RandomTaskWidget
 * @package app\modules\task\components
 */
class RandomTaskWidget extends  Widget
{
    /**
     * @var array Задачи из которых выбирается случайная
     */
    public $tasks = [];

    public function run(){

        if (!empty($this->tasks)) {
            $tasks = [];
            foreach ($this->tasks as $t) {
                if ($t['status'] != 0) {
                    $tasks += array(
                        $t['id'] => $t,
                    );
                }
            }

        if(!empty($tasks))
            $task = $tasks[array_rand($tasks)];
        else
            $task['title'] = 'Все задачи выполнены, добавьте новую!';

        return $this->render('randomTaskWidget', [
                'task' => $task,
            ]);
        }
    }

}