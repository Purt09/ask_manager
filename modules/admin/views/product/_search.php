<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'price') ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList(yii::$app->params['status'],['prompt' => 'Все']) ?>
        </div>
        <div class="col-sm-5">
        <?= $form->field($model, 'name') ?>
        </div>

        <?//= $form->field($model, 'url') ?>

        <div class="col-sm-4">
        <?= $form->field($model, 'characteristics') ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->field($model, 'description_min') ?>
        </div>
        <div class="col-sm-4">
        <?php echo $form->field($model, 'description') ?>
        </div>

        <?php // echo $form->field($model, 'meta_keywords') ?>

        <?php // echo $form->field($model, 'meta_description') ?>      

        <?php // echo $form->field($model, 'created_at') ?>

        <?php // echo $form->field($model, 'updated_at') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?//= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
