<?php

use app\modules\task\components\TasksListWidget;

?>
<div class="container">
    <div class="row">
        <div class="p-3 mb-2 bg-info text-white row shadow ">
            Выполненные задачи:
        </div>
        <?= TasksListWidget::widget([
            'tasks' => $tasks,
            'status' => 0,
        ]) ?>
    </div>
</div>
