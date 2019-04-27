<?php
use yii\helpers\Html;
use app\modules\task\Module;
use yii\helpers\Url;

$this->title = Module::t('module', 'TASKS');
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
                <?= Html::a(Module::t('module', 'TASK_COMPLETE'), ['user/overdue'], ['class' => 'btn btn-info']) ?>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm-8">
            <div class="p-3 mb-2 bg-info text-white" >
                <?= Module::t('module', 'TASK_ACTIVE') ?>:
            </div>

            <?php foreach ($modelsactive as $model) : ?>
            <div class="bg-light">
                    <? echo Html::a('выполненно', Url::to(['complete', 'id' => $model->id]), ['class'=>'btn btn-success btn-sm']) ?>

                    <a href="<?= Url::to(['update', 'id' => $model->id]) ?>" class="text-body pl-3">
                    <?= $model->title ?> </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="col-sm-4">
            <div class="p-3 mb-2 bg-danger text-white" >
                <?= Module::t('module', 'TASK_OVERDUE') ?>:
            </div>
            <?php foreach ($modelspros as $model) : ?>
                <div class="bg-light table-striped">
                    <? echo Html::a('выполненно', Url::to(['complete', 'id' => $model->id]), ['class'=>'btn btn-success btn-sm']) ?>

                    <a href="<?= Url::to(['update', 'id' => $model->id]) ?>" class="text-body pl-3">
                        <?= $model->title ?> </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>



