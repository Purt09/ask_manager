<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model app\models\StatyaStatic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="statya-static-form">

    <div class="form-group">
        Дата создания: <?=$model->created_at; ?>
        <? if(!empty($model->updated_at)){ ?>
            / Дата обновления: <?=$model->updated_at; ?>
        <?}?>
    </div>

    <?php $form = ActiveForm::begin(); ?>

   <? if (Yii::$app->user->can('Admin')) { ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <? } else { ?>

        <? if (!$model->isNewRecord) { ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
            </div>
        <? } ?>

    <? } ?>


    <?//= $form->field($model, 'status')->textInput()->dropDownList(yii::$app->params['status']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <? if (empty($model->id)) {
        echo '<div class="form-group"> Создайте элемент! После этого продолжите обновление.</div>';
    } else { ?>


        <?//= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'description')->widget(CKEditor::className(),[
            'editorOptions' => ElFinder::ckeditorOptions(['elfinder', 'path' => 'statya-static/'.$model->id],[
                    'rows' => 6,
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по умолчанию false
                ]),
        ]) ?>


        <?//= $form->field($model, 'created_at')->textInput() ?>

        <?//= $form->field($model, 'updated_at')->textInput() ?>

    <? } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
