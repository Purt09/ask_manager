<?php

use yii\helpers\Html;
use app\modules\user\components\UsersListWidget;
use app\modules\task\Module;
use app\modules\task\components\CreateTaskWidget;
use app\modules\task\components\TasksListWidget;
use app\modules\project\components\CreateProjectWidget;
use app\modules\project\components\ProjectWidget;


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
            <div class="col-sm-8">
                <h2><?= $model->title ?> </h2>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="p-3 mb-2 bg-info text-white row shadow ">
                                <?= Module::t('module', 'TASKS') ?>
                            </div>
                            <?= TasksListWidget::widget([
                                'tasks' => $tasks,
                                'status' => 1,
                                'redirect' => '/project/default/' . $model['id'],
                            ]) ?>

                            <div class="text-center">
                                <?= Html::button(Module::t('module', 'TASK_CREATE'), ['data-toggle' => 'modal', 'data-target' => '#CreateTask' . $model->id, 'class' => 'btn-success btn']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="row">

                            <div class="p-3 mb-2 bg-secondary text-white row shadow  ">
                                <?= Module::t('module', 'TASKS_TIMEOUT') ?>
                            </div>
                            <?= TasksListWidget::widget([
                                'tasks' => $tasks,
                                'status' => 2,
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
                                        'redirect' => 'default/view',
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


            </div>
            <div class="col-sm-4 text-center">
                <?php if ($model['parent_id'] == null): ?>
                    <h2>Подпроекты:</h2>
                    <div class="col-sm-12 mr-3 ">
                        <div class="row">
                            <?php if (empty($projects)) : ?>
                                <h2>В данном проекте отсуствуют подпроекты</h2>
                            <?php else: ?>
                                <?= ProjectWidget::widget([
                                    'tasks' => $subtasks,
                                    'projects' => $projects,
                                    'csscol' => 12,
                                    'id' => $model->id,
                                    'parent' => false,
                                    ]) ?>
                            <?php endif; ?>
                            <?= Html::button(\app\modules\project\Module::t('module', 'SUBPROJECT_ADD'), ['data-toggle' => 'modal', 'data-target' => '#CreateProject', 'class' => 'btn-success btn ']) ?>
                        </div>
                    </div>
                <?php endif; ?>

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
                        <dt>Подкатегорий: <?= count($projects) ?></dt>
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
                    </dl>
                    <?= Html::a('Выполненные задачи', ['/project/default/complete', 'id' => $model->id], ['class' => 'btn btn-default btn-block']) ?>
                    <?php if (Yii::$app->user->identity->id == $model['creator_id']): ?>
                        <?= Html::a('Добавить друга', ['default/friends', 'project_id' => $model->id], ['class' => 'btn btn-default btn-block']) ?>
                        <?= Html::a('Закрыть проект', ['default/delete', 'id' => $model->id], ['class' => 'btn btn-default btn-block']) ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>


    </div>
    </div>

<?= CreateTaskWidget::widget(['project' => $model, 'projects' => $projects]) ?>
<?= CreateProjectWidget::widget([
        'parent_id' => $model->id,
        'projects' => $projects,
]);


