<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\modules\user\Module;
/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
$this->title = Yii::t('app', 'TITLE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'PROFILE'), 'url' => ['index', 'id' => Yii::$app->user->identity->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(['id' => 'profile-update-form']); ?>

        <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <?= $form->field($model, 'first_name')->textInput(['placeholder' => $model->getAttributeLabel('first_name')]) ?>

        <?= $form->field($model, 'last_name')->textInput(['placeholder' => $model->getAttributeLabel('last_name')]) ?>

        <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '+7 (999) 999 99 99',
        ])->textInput(['placeholder' => $model->getAttributeLabel('phone')]); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>