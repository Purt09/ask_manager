<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\project\models\Project;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'time_at')->widget(\kartik\datecontrol\DateControl::className(),[
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME
    ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(Project::find()->select(['title', 'id'])->indexBy('id')->column(), ['prompt' => '']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
