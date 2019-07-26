<?php

namespace app\modules\task\components;

use yii\base\Widget;
use app\modules\task\models\Task;

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


        $task = $tasks[array_rand($tasks)];

        return $this->render('randomTaskWidget', [
                'task' => $task,
            ]);
        }
    }

}