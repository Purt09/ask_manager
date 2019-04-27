<?php
use app\modules\task\Module;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Выполненные задачи";
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'TASKS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="text-center" >
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
            <div class="p-3 mb-2 bg-warning text-black" >
                <?= Module::t('module', 'TASK_COMPLETE') ?> :
            </div>
            <?php foreach ($models as $model) : ?>
            <p>
                    <a href="<?= Url::to(['update', 'id' => $model->id]) ?>">
                       <?= $model->title ?> </a>
            </p>
            <?php endforeach; ?>
        </div>
    </div>
</div>
