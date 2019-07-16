<?php
use app\modules\user\components\UsersListWidget;
?>
<h1>Пригласить в проект участников</h1>
<div class="invite-friend">
    <?= UsersListWidget::widget([
        'users' => $users,
        'photo_size' => 1,
        'button' =>
            [
                '0' => [
                    'text' => 'Пригласить в проект',
                    'url' => 'default/add-friend',
                    'class' => 'btn btn-default',
                    'redirect' => '/profile/' . $project_id,
                    'id' => $project_id,

                ],
            ],
    ]) ?>
</div>
