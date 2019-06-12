<?php
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use app\modules\task\Module;
use yii\helpers\Html;
use app\modules\project\models\Project;
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'updated_at')->widget(\kartik\datecontrol\DateControl::className(),[
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATETIME
    ]) ?>


    <?= $form->field($model, 'project_id')->dropDownList(Project::find()->select(['title', 'id'])->indexBy('id')->column(), ['prompt' => ''])?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Module::t('module', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>