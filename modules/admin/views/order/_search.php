<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'price') ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'status')->dropDownList(yii::$app->params['orderStatus'],['prompt' => 'Все']) ?>
        </div>
        <div class="col-sm-4">
            <?
                // $arrDelivery = \yii\helpers\ArrayHelper::map(yii::$app->params['delivery'],'id','name');
                // echo $form->field($model, 'delivery_id')->dropDownList($arrDelivery, ['prompt' => 'Все']); 
            ?>
        </div>
    </div>        

    <?//= $form->field($model, 'id') ?>

    <?//= $form->field($model, 'user_id') ?>

    <?//= $form->field($model, 'user_info_id') ?>

    <?//= $form->field($model, 'description') ?>

    <?//= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'delivery_description') ?>

    <?php // echo $form->field($model, 'delivery_price') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
