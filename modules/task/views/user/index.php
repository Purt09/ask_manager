<?php

use yii\helpers\Html;
use app\modules\task\Module;
use app\modules\task\components\TasksListWidget;
use app\modules\task\components\CreateTaskWidget;

/* @var $modelsactive app\modules\task\models\Task */
$time = time();

$this->title = Module::t('module', 'TASKS');
$this->params['breadcrumbs'][] = $this->title;


?>


    <div class="container">
        <div class="text-center">
            <div class="col-sm-7">
                <div class="row p-3">
                    <?= Html::button(Module::t('module', 'TASK_CREATE'), ['data-toggle' => 'modal', 'data-target' => '#CreateTask', 'class' => 'btn-success btn']) ?>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="row p-3">
                    <?= Html::a(Module::t('module', 'TASK_COMPLETE'), ['user/done'], ['class' => 'btn btn-warning']) ?>
                </div>
            </div>

        </div>

        <hr/>
        <div class="row">
            <div class="col-sm-6">
                <div class="p-3 mb-3 bg-info text-white row shadow ">
                    <?= Module::t('module', 'TASK_ACTIVE') ?>:
                </div>
                <?= TasksListWidget::widget([
                    'tasks' => $models,
                    'status' => 1,
                ])?>
            </div>
            <br>

            <div class="col-sm-3 ml-4">
                <div class="p-3 mb-2 bg-danger text-white row shadow ">
                    <?= Module::t('module', 'TASK_OVERDUE') ?>:
                </div>
                <?= TasksListWidget::widget([
                    'tasks' => $models,
                    'status' => 2,
                ])?>
            </div>
            <div class="col-sm-2 ml-4">
                wqe
            </div>
        </div>
    </div>

<?= CreateTaskWidget::widget(['projects' => $projects]) ?>