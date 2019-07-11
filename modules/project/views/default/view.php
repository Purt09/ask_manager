<?php

use yii\helpers\Html;
use app\modules\user\components\UsersWidget;
use yii\helpers\Url;
use app\modules\task\Module;
use app\components\TimeSupport;
use app\modules\task\components\CreateTaskWidget;


/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Project */
/* @var $models app\modules\task\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'PROJECTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$time = time();
?>
<div class="project-view">

    <br>
    <div class="container">
        <div class="col-md-8">
            <h2><?= $model->title ?> </h2>
            <div class="mod-row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="p-3 mb-2 bg-info text-white row mr-1 shadow ">
                            <?= Module::t('module', 'TASKS') ?>
                        </div>
                        <div class="p-3">
                            <?php foreach ($tasks as $task): ?>
                                <?php if (($task['project_id'] == $model->id) && ($task['status'] == 1)): ?>
                                    <div class="bg-light  p-1 shadow-sm row mr-1 del<?= $task['id'] ?>">
                                        <?php
                                        $id = $task['id'];
                                        $idtoggle = 'toggle-event-' . $task['id'];
                                        $id_del_class = 'div.del' . $task['id'];
                                        $tool_id = 'tooltip-' . $task['id'];
                                        $url = Url::to(['/task/user/complete', 'id' => $task['id'], 'redirect' => '/project/' . $model['id']]);
                                        $url = '"http://' . $_SERVER['SERVER_NAME'] . $url . '"';

                                        $script = <<< JS
$(function() {
        $('#$idtoggle').change(function() {
            $('$id_del_class').remove();
            document.location.href = $url;
        })
    })
   $('#$tool_id').tooltip();
JS;

                                        $this->registerJs($script, yii\web\View::POS_READY);
                                        ?>
                                        <div class="col-xs-1">
                                            <?= '<input id="' . $idtoggle . '" type="checkbox" checked data-toggle="toggle" data-on="<i class=\'glyphicon glyphicon-remove\'> </i>" data-off="<i class=\'glyphicon glyphicon-ok\'> </i>" data-size="sm" data-onstyle="success">';
                                            ?>
                                        </div>
                                        <div class="col-xs-8 ml-3">
                                            <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>"
                                               title="<?= $task['description'] ?>" id="<?= $tool_id ?>"
                                               class="text-body pl-3">
                                                <?= $task['title'] ?> </a>
                                        </div>
                                        <div class="pull-right col-3">
                                            <?php if ($task['updated_at'] != null): ?>
                                                <?= TimeSupport::createtime($task['updated_at'] - $time) ?>
                                            <? endif; ?>
                                        </div>
                                    </div>
                                    <br>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <div class="text-center">
                                <?= Html::button(Module::t('module', 'TASK_CREATE'), ['data-toggle' => 'modal', 'data-target' => '#CreateTask' . $model->id, 'class' => 'btn-success btn']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 ml-4 ">
                    <div class="row">

                        <div class="p-3 mb-2 bg-secondary text-white row mr-1 shadow  ">
                            <?= Module::t('module', 'TASKS_TIMEOUT') ?>
                        </div>
                        <div class="p-3">
                            <?php foreach ($tasks as $task): ?>
                                <?php if (($task['project_id'] == $model->id) && ($task['status'] == 2)): ?>
                                    <div class="bg-light  p-1 shadow-sm row mr-1 del<?= $task['id'] ?>">
                                        <?php
                                        $id = $task['id'];
                                        $idtoggle = 'toggle-event-' . $task['id'];
                                        $id_del_class = 'div.del' . $task['id'];
                                        $tool_id = 'tooltip-' . $task['id'];
                                        $url = Url::to(['/task/user/complete?redirect=/project/' . $model['id'], 'id' => $task['id']]);
                                        $url = '"http://' . $_SERVER['SERVER_NAME'] . $url . '"';

                                        $script = <<< JS
$(function() {
        $('#$idtoggle').change(function() {
            $('$id_del_class').remove();
            document.location.href = $url;
        })
    })
   $('#$tool_id').tooltip();
JS;

                                        $this->registerJs($script, yii\web\View::POS_READY);
                                        ?>
                                        <div class="col-xs-1">
                                            <?= '<input id="' . $idtoggle . '" type="checkbox" checked data-toggle="toggle" data-on="<i class=\'glyphicon glyphicon-remove\'> </i>" data-off="<i class=\'glyphicon glyphicon-ok\'> </i>" data-size="sm" data-onstyle="warning">';
                                            ?>
                                        </div>
                                        <div class="col-xs-8 ml-3">
                                            <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>"
                                               title="<?= $task['description'] ?>" id="<?= $tool_id ?>"
                                               class="text-body pl-3">
                                                <?= $task['title'] ?> </a>
                                        </div>
                                        <div class="pull-right col-3">
                                            <?php if ($task['updated_at'] != null): ?>
                                                <?= TimeSupport::createtime($task['updated_at'] - $time) ?>
                                            <? endif; ?>
                                        </div>
                                    </div>
                                    <br>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="p-3 mb-2 bg-primary text-white row mr-1 shadow ">
                        Участники:
                    </div>
                    <?= UsersWidget::widget([
                        'users' => $users,
                        'button' => true,
                    ]) ?>
                </div>
            </div>
            <?php if (Yii::$app->user->identity->id === $model['creator_id']): ?>
            <div class="col-md-5 ml-5">
                <div class="row">
                    <div class="p-3 mb-2 bg-primary text-white row mr-1 shadow ">
                        Панель управления:
                    </div>
                                <p>Здесь можно будет управлять проектом, в роли администратора</p>

                            <hr>

                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <h2>Подпроекты:</h2>
            <div class="col-sm-12 mr-3 ">
                <div class="row">
                    <?php if (empty($subprojects)) : ?>

                        <h2>В данном проекте отсуствуют подпроекты</h2>
                        <?= Html::button(\app\modules\project\Module::t('module', 'SUBPROJECT_ADD'), ['data-toggle' => 'modal', 'data-target' => '#CreateProject', 'class' => 'btn-success btn']) ?>
                    <?php else: ?>
                        <?= \app\modules\project\components\ProjectWidget::widget(['projects' => $subprojects, 'csscol' => 12, 'id' => $model->id]) ?>

                        <br>
                    <?php endif; ?>
                </div>
            </div>
        </div>


    </div>
</div>

<?= CreateTaskWidget::widget(['project' => $model, 'projects' => $subprojects]) ?>


