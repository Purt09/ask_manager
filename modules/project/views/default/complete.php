<?php

use app\modules\task\components\UserListWidget;

?>
<div class="container">
    <div class="row">
        <div class="p-3 mb-2 bg-info text-white row shadow ">
            Выполненные задачи:
        </div>
        <?= UserListWidget::widget([
            'tasks' => $tasks,
            'status' => 0,
            'redirect' => '/project/default/' . $model['id'],
        ]) ?>
    </div>
</div>
