<?php
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use app\modules\task\Module;
use yii\helpers\Html;
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    --><?// $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->widget(DatePicker::className(), [
        'name' => 'dp_5',
        'type' => DatePicker::TYPE_INLINE,
        'value' => '23-Feb-1982',
        'type' => DatePicker::TYPE_INLINE,
        'pluginOptions' => [
            'format' => 'yyyymmdd',
            'multidate' => true
        ],
        'options' => [
            // you can hide the input by setting the following
            // 'style' => 'display:none'
        ]
    ]) ?>

<!--    --><?//= $form->field($model, 'created_at')->widget(DatePicker::className(), [
//        'name' => 'anniversary',
//        'value' => '08/10/2004',
//        'readonly' => true,
//
//        'removeButton' => false,
//        'pluginOptions' => [
//            'autoclose'=>true,
//            'format' => 'yyyymmdd'
//        ]
//    ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Module::t('module', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>