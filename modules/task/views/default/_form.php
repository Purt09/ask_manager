<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\task\Module;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'updated_at')->widget(\kartik\datecontrol\DateControl::className(),[
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME
    ]) ?>




    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Module::t('module', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
