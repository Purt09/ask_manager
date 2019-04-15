<?php
use app\modules\task\Module;
use yii\helpers\Html;
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
                    - <?= $model->title ?>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
</div>
