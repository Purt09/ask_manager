<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="video-form">
    <div class="form-group">
        Дата создания: <?=$model->created_at; ?>
        <? if(!empty($model->updated_at)){ ?>
            / Дата обновления: <?=$model->updated_at; ?>
        <?}?>
    </div>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->textInput()->dropDownList(yii::$app->params['status']) ?>
        </div>
    </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'view_main')->textInput()->dropDownList(yii::$app->params['status_view_main']) ?>
        </div>
    </div>
    
    <?= $form->field($model, 'sort_main')->textInput([
            'maxlength' => true,
            'min' => 1,
        ]) ?>

    <?//= $form->field($model, 'view_main')->checkbox() ?>

    <?//= $form->field($model, 'status')->textInput() ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    <?//= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
