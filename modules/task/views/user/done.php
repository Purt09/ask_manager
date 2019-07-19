<?php

use app\modules\task\Module;
use yii\helpers\Html;
use app\modules\task\components\TasksListWidget;
/* @var $models app\modules\task\models\Task */

$this->title = "Выполненные задачи";
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'TASKS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="text-center pb-5">
        <div class="col-sm-6">
            <div class="row">
                <?= Html::a(Module::t('module', 'TASK_CREATE'), ['user/create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <?= Html::a(Module::t('module', 'TASKS'), ['user/index'], ['class' => 'btn btn-info']) ?>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm">
            <div class="p-3 mb-2 bg-warning shadow  text-black row mb-5">
                <?= Module::t('module', 'TASK_COMPLETE') ?> :
            </div>
            <?= TasksListWidget::widget([
                'tasks' => $models,
                'status' => 0,
                'complete' => 'uncomplete',
            ])?>
        </div>
    </div>
</div>
