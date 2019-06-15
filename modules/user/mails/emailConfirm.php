<?php

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/confirm-email', 'token' => $user->email_confirm_token]);
?>

<?= Yii::t('app', 'HELLO {username}', ['username' => $user->username]); ?>

<?= Yii::t('app', 'FOLLOW_TO_CONFIRM_EMAIL') ?>

<?= $resetLink ?>

<?= Yii::t('app', 'IGNORE_IF_DO_NOT_REGISTER') ?>