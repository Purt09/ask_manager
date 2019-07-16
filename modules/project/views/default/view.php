<?php

use yii\helpers\Html;
use app\modules\user\components\UsersListWidget;
use app\modules\task\Module;
use app\modules\task\components\CreateTaskWidget;
use app\modules\task\components\UserListWidget;


/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Project */
/* @var $models app\modules\task\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'PROJECTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


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
                        <?= UserListWidget::widget([
                            'tasks' => $tasks,
                            'status' => 1,
                            'redirect' => '/project/default/' . $model['id'],
                        ])?>

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
                        <?= UserListWidget::widget([
                                'tasks' => $tasks,
                                'status' => 2,
                        ])?>

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
        <div class="col-sm-4">
            <h2>Подпроекты:</h2>
            <div class="col-sm-12 mr-3 ">
                <div class="row">
                    <?php if (empty($subprojects)) : ?>

                        <h2>В данном проекте отсуствуют подпроекты</h2>
                        <?= Html::button(\app\modules\project\Module::t('module', 'SUBPROJECT_ADD'), ['data-toggle' => 'modal', 'data-target' => '#CreateProject', 'class' => 'btn-success btn']) ?>
                    <?php else: ?>
                        <?= \app\modules\project\components\ProjectWidget::widget(['projects' => $subprojects, 'csscol' => 12, 'id' => $model->id]) ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (Yii::$app->user->identity->id == $model['creator_id']): ?>
                <div class="col-sm-12">
                        <div class="p-3 mb-2 mt-4 bg-primary text-white ">
                            Панель управления:
                        </div>
                        <?= Html::a('Добавить друга', ['default/friends', 'project_id' => $model->id], ['class' => 'btn btn-default btn-block'])?>
                        <?= Html::a('Статистика', ['default/stat'], ['class' => 'btn btn-default btn-block '])?>
                        <hr>

                    </div>
                </div>
            <?php endif; ?>
        </div>


    </div>
</div>

<?= CreateTaskWidget::widget(['project' => $model, 'projects' => $subprojects]) ?>


