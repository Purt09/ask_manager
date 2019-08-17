<?php

use yii\helpers\Html;
use app\modules\task\Module;
use app\modules\task\components\TasksListWidget;
use app\modules\task\components\CreateTaskWidget;
use app\modules\task\components\RandomTaskWidget;

/* @var $modelsactive app\modules\task\models\Task */

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
            <div class="col-sm-10">
            <?= \app\modules\project\components\FullProjectWidget::widget([
                'tasks' => $tasks,
                'project' => ['title' =>  'Все', 'id' =>  0],
                'projects' => $projects,
                'users' => $users,
            ]) ?>
            </div>
            <div class="col-sm-2 ml-4">
                <?= RandomTaskWidget::widget(['tasks' => $tasks])?>
            </div>
        </div>
    </div>

