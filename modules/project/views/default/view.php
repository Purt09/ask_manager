<?php

use yii\helpers\Html;
use app\modules\user\components\UsersListWidget;
use app\modules\project\components\CreateProjectWidget;
use app\modules\task\components\RandomTaskWidget;
use app\modules\user\components\ChatWidget;



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


            <div class="col-sm-12">
                <div class="row">
                    <?= \app\modules\project\components\FullProjectWidget::widget([
                        'project' => $model,
                        'projects' => $projects,
                        'tasks' => $tasks,
                        'users' => $users,
                    ]) ?>
                </div>
                <?php if ($model['chat_id'] != 0): ?>
                    <div class="col-sm-12">
                        <div class="row">
                            <?= ChatWidget::widget([
                                'chat_id' => $model->chat_id,
                                'users' => $users,
                            ]) ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="p-3 mb-2 bg-primary text-white row shadow ">
                            Участники:
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 text-center">
            <div class="col-sm-12 text-left">
                <div class="p-3 mb-2 mt-4 bg-primary text-white ">
                    Данные о проекте:
                </div>
                <?php if (!empty($model->description)): ?>
                    Описание:
                    <div class="bg-light">
                        <?= $model->description ?>
                    </div>
                <?php endif; ?>
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
                    <br>
                    <div class="p-3 mb-2 mt-4 bg-primary text-white ">
                        Панель администратора:
                    </div>
                    <hr>
                    <?php if ($model['parent_id'] === null) : ?>
                        <?= Html::a('Добавить друга', ['default/friends', 'project_id' => $model->id], ['class' => 'btn btn-success btn-block']) ?>
                    <?php endif; ?>
                    <?= CreateProjectWidget::widget([
                    'parent' => $model,
                    'projects' => $projects,
                    'title' => 'Добавить подпроект',
                ]) ?>
                    <br>
                    <?= Html::a('Редактировать проект', ['default/update', 'id' => $model->id], ['class' => 'btn btn-warning btn-block']) ?>
                    <?php if ($model['chat_id'] == 0): ?>
                        <?= Html::a('Создать чат', ['default/create-chat', 'id' => $model->id, 'title' => $model->title], ['class' => 'btn btn-success btn-block']) ?>
                    <?php endif; ?>
                    <?= Html::a('Закрыть проект', ['default/delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-block']) ?>
                <?php endif; ?>


            </div>
        </div>

    </div>



