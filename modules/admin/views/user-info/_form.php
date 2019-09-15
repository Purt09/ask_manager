<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Country;

/* @var $this yii\web\View */
/* @var $model app\models\UserInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-info-form">

    <div class="form-group">
        Дата создания: <?=$model->created_at; ?>
        <? if(!empty($model->updated_at)){ ?>
            / Дата обновления: <?=$model->updated_at; ?>
        <?}?>
    </div>
    
    <?php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'surname')->textInput() ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?//= $form->field($userInfo, 'telephone')->textInput(['maxlength' => true]) 
        $telephone_code = $form->field($model, 'telephone_code',['options' => ['placeholder' => 'код' ],'template' => '{input}'])->input(null, ['placeholder' => 'код']);
    ?>
    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
    <?/*= $form->field($model, 'telephone',['options' => ['class' => 'form-group'],'template' => '{label} <div class="row"><div class="col-md-2 col-sm-3 col-xs-4" style="padding-right:3px;">'.$telephone_code.'</div><div class="col-md-10 col-sm-9 col-xs-8" style="padding-left:3px;">{input}</div></div>{error}',])->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => ['(9{3}) 999-99-99'],
        //'mask' => ['+{0,1}9{1,5} (9{3}) 999-99-99'],
        // 'mask' => ['9 (999) 9999-99-99'],


    ])->textInput(['placeholder' => '(___) ___-__-__']) 
    //])->textInput(['placeholder' => '_ (___) ___-__-__']) 
    //->textInput(['placeholder' => $userInfo->getAttributeLabel('telephone')]) 
    */?>
    <?/*= $form->field($model, 'telephone')->textInput(['minlength' => true])->widget(\yii\widgets\MaskedInput::className(), [
                    'mask' => ['+\7 999 999-99-99'],
                    'clientOptions' => [
                        'alias' =>  'number',
                        // 'groupSeparator' => ',',
                        // 'autoGroup' => true
                    ],
                ]) */?>

    <?//= $form->field($userInfo, 'country_id')->textInput()
    $arrCountry = Country::find()->all();
    if(!empty($arrCountry)){
        $arrCountry = \yii\helpers\ArrayHelper::map($arrCountry,'id','name');
    } else {
        $arrCountry = [];
    }
    if (empty($model->country_id)) {
        $model->country_id = 168;
    }
    echo $form->field($model, 'country_id')->textInput()->dropDownList($arrCountry,['prompt' => '']);

    ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'postcode')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    <?//= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
