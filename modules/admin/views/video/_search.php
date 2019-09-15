<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VideoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList(yii::$app->params['status'],['prompt' => 'Все']) ?>
        </div>
        <div class="col-sm-6">
        <?= $form->field($model, 'url') ?>
        </div>
        <div class="col-sm-3">
        <?= $form->field($model, 'view_main')->dropDownList(yii::$app->params['status_view_main'],['prompt' => 'Все']) ?>
        </div>
    </div>
    
    <?//= $form->field($model, 'id') ?>

    <?//= $form->field($model, 'url') ?>

    <?//= $form->field($model, 'status') ?>

    <?//= $form->field($model, 'created_at') ?>

    <?//= $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
