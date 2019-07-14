<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\modules\user\Module;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\ChangePasswordForm */

$this->title = Module::t('module', 'TITLE_PASSWORD_CHANGE');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'PROFILE'), 'url' => ['index', 'id' => Yii::$app->user->identity->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-password-change">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">

        <?php $form = ActiveForm::begin(['id' => 'password-change-form']); ?>

        <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'BUTTON_SAVE'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>