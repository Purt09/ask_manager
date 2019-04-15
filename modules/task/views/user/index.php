<?php
use yii\helpers\Html;
Use app\modules\task\Module;
?>


<div class="container">
    <div class="text-center" >
        <div class="col-sm-6">
            <div class="row">
                <?= Html::a(Module::t('module', 'TASK_CREATE'), ['default/create'], ['class' => 'btn btn-success']) ?>
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
                <?= Module::t('module', 'TASK_ACTIVE') ?> :
            </div>
            <?php foreach ($modelsactive as $model) : ?>
                <p>
                    - <?= $model->title ?>
                </p>
            <?php endforeach; ?>
        </div>

        <div class="col-sm-4">
            <div class="p-3 mb-2 bg-danger text-white" >
                <?= Module::t('module', 'TASK_OVERDUE') ?> :
            </div>
            <?php foreach ($modelspros as $model) : ?>
                <p>
                    - <?= $model->title ?>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
</div>

