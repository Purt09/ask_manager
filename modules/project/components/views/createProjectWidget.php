<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\project\models\Project;
use app\modules\task\Module;

?>



<!-- Modal -->
<div class="modal fade" id="CreateProject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <?php $form = ActiveForm::begin(); ?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel"><?= Module::t('module', 'PROJECT_CREATE') ?></h4>
            </div>
            <div class="modal-body">

                <?= $form->field($model, 'time_at')->widget(\kartik\datecontrol\DateControl::className(),[
                    'type' => \kartik\datecontrol\DateControl::FORMAT_DATE
                ]) ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'parent_id')->dropDownList($projects, ['prompt' => '']) ?>

                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>




                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= Module::t('module', 'CLOSE') ?></button>
                    <?= Html::submitButton(Module::t('module', 'SAVE'), ['class' => 'btn btn-success', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>