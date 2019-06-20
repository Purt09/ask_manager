<?php

use yii\helpers\Html;
use app\modules\project\components\CreateProjectWidget;
use yii\helpers\Url;
use app\modules\task\Module;


/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'PROJECTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <br>
    <div class="container">
        <div class="col-sm-8">
            <h2><?php echo $model->title ?> </h2>
            <div class="mod-row">
                <div class="col-sm-8 mr-3 border rounded-bottom shadow-sm rounded-lg">
                    <div class="row">
                        <div class="p-3  bg-info text-white">
                            <?= Module::t('module', 'TASKS') ?>
                        </div>
                        <div class="p-3 bg-light rounded-bottom">
                            <?php foreach ($tasksactive as $task): ?>
                                <div class="bg-light test">
                                    <div class="pull-right">  <?php if (!empty($task['time'])) echo createtime($task['time']) ?> </div>
                                    <? echo Html::a('выполненно', Url::to(['/task/user/complete', 'id' => $task['id']]), ['class' => 'btn btn-success btn-sm']) ?>

                                    <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>"
                                       class="text-body pl-3">
                                        <?= $task['title'] ?> </a>

                                </div>
                                <hr>
                            <?php endforeach; ?>
                            <?php $datatarget = '#CreateTask' . $model->id; ?>
                            <div class="text-center">
                                <?= Html::button(Module::t('module', 'TASK_CREATE'), ['data-toggle' => 'modal', 'data-target' => $datatarget, 'class' => 'btn-success btn ']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mr-3 border rounded-bottom shadow-sm rounded-lg">
                    <div class="row">

                        <div class="p-3  bg-secondary text-white ">
                            <?= Module::t('module', 'TASKS_TIMEOUT') ?>
                        </div>
                        <div class="p-3 bg-light mod-row">
                            <?php foreach ($tasksoverdue as $task): ?>
                                <div class="bg-light test">

                                    <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>"
                                       class="text-body pl-3">
                                        <?= $task['title'] ?> </a>


                                    <?= Html::a('(выполнено)', Url::to(['/task/user/complete', 'id' => $task['id'], 'redirect' => '/project/default/view']), ['class' => ' text-secondary']) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 mr-3 border rounded-bottom shadow-sm rounded-lg">

                <div class="p-3 mb-2 bg-primary text-white ">
                    Участники:
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="col-sm-12 mr-3 ">
                <div class="row">
                    <br><br><br>
                    <?php if (empty($subprojects)) : ?>

                        <h2>В данном проекте отсуствуют под проекты</h2>
                        <?= Html::button(\app\modules\project\Module::t('module', 'SUBPROJECT_ADD'), ['data-toggle' => 'modal', 'data-target' => '#CreateProject', 'class' => 'btn-success btn']) ?>
                    <? else: ?>
                        <?php foreach ($subprojects as $subproject): ?>
                            <?= \app\modules\project\components\ProjectWidget::widget(['tpl' => 'project', 'id' => $subproject->id]) ?>

                        <br>
                        <?php endforeach; ?>
                    <? endif; ?>
                </div>
            </div>
        </div>


    </div>
</div>

<?= CreateProjectWidget::widget(['parent_id' => $model->id]) ?>


