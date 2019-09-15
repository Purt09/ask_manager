<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use yii\bootstrap\Modal;

use app\models\UserInfo;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Письмо: '.Yii::t('app', 'Order').' №'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">
<div class="text-center">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Send email'), ['send-email', 'id' => $model->id], ['class' => 'btn btn-primary send_email']); ?>
</div>
    
<?= $html; ?>
<div class="text-center">
    <?= Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Send email'), ['send-email', 'id' => $model->id], ['class' => 'btn btn-primary send_email']); ?>
</div>
<?php
    yii\bootstrap\Modal::begin([
        'header' => Yii::t('app', 'Send email'),
        'id' => 'modal_send_email',
        'size' => 'modal-sm',     
    ]);
?>
<?php yii\bootstrap\Modal::end(); ?>