<?php

use yii\helpers\Html;
use app\modules\user\components\UsersListWidget;
use app\modules\task\Module;
use app\modules\task\components\CreateTaskWidget;
use app\modules\task\components\TasksListWidget;
use app\modules\project\components\CreateProjectWidget;
use app\modules\project\components\ProjectWidget;
use app\modules\task\components\RandomTaskWidget;


/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Project */
/* @var $models app\modules\task\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'PROJECTS'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$hide = true;
if (Yii::$app->user->identity->id == $model['creator_id']) $hide = false;
?>
    <div class="project-view">
        <br>
        <div class="container">
            <div class="col-sm-9">
                <h2><?= $model->title ?> </h2>
                <div class="col-sm-11">
                    <div class="row">
                        <?= \app\modules\project\components\FullProjectWidget::widget([
                            'project' => $model,
                            'projects' => $projects,
                            'tasks' => $tasks,
                            'users' => $users,
                        ]) ?>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="row">
                        <div class="p-3 mb-2 bg-primary text-white row shadow ">
                            Участники:
                        </div>
                        <?= UsersListWidget::widget([
                            'users' => $users,
                            'button' => [
                                '0' => [
                                    'text' => 'Удалить из проекта',
                                    'url' => '/project/default/del-friend',
                                    'class' => 'btn btn-warning btn-sm',
                                    'redirect' => '/project/' . $model->id,
                                    'hide' => $hide,
                                    'id' => $model->id,
                                ],
                                '1' => [
                                    'text' => 'Назначить лидером',
                                    'url' => '/project/default/new-leader',
                                    'class' => 'btn btn-default btn-sm',
                                    'redirect' => '/project/' . $model->id,
                                    'hide' => $hide,
                                    'id' => $model->id,
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 text-center">

                <div class="col-sm-12 text-left">
                    <div class="p-3 mb-2 mt-4 bg-primary text-white ">
                        Панель управления:
                    </div>
                    <h2>Данные о проекте:</h2>
                    <hr>
                    <dl class="">
                        <dt>Участники: <?= count($users) ?></dt>
                        <?php foreach ($users as $user): ?>
                            <dd><?= $user->username ?></dd>
                        <?php endforeach; ?>
                        <dt>Подкатегорий: <?= count($projects) - 1 ?></dt>
                        <dt>Задач: <?= count($tasks) ?></dt>
                        <?php
                        $done = 0;
                        $active = 0;
                        $passive = 0;
                        foreach ($tasks as $t) {
                            if ($t['status'] == 0) $done++;
                            if ($t['status'] == 1) $active++;
                            if ($t['status'] == 2) $passive++;
                        }
                        ?>
                        <dd> Активных: <?= $active ?></dd>
                        <dd> Выполненных: <?= $done ?></dd>
                        <dd> Просроченных: <?= $passive ?></dd>
                        <?php foreach ($users as $user): ?>
                            <?php if ($user['id'] == $model['creator_id']) : ?>
                                <dd> Руководитель: <?= $user['username'] ?> </dd>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </dl>
                    <?= Html::a('Выполненные задачи', ['/project/default/complete', 'id' => $model->id], ['class' => 'btn btn-default btn-block']) ?>
                    <?= RandomTaskWidget::widget(['tasks' => $tasks]); ?>

                    <?php if (Yii::$app->user->identity->id == $model['creator_id']): ?>
                        <?= Html::a('Закрыть проект', ['default/delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-block']) ?>
                        <?php if ($model['parent_id'] === null) : ?>
                            <?= Html::a('Добавить друга', ['default/friends', 'project_id' => $model->id], ['class' => 'btn btn-success btn-block']) ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>


    </div>
    </div>

<?= CreateProjectWidget::widget([
    'parent_id' => $model->id,
    'projects' => $projects,
]);


