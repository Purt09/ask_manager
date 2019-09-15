<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dvizh\cart\widgets\DeleteButton;
use dvizh\cart\widgets\ChangeCount;
use dvizh\cart\widgets\CartInformer;
use app\models\Country;

/* @var $this yii\web\View */
/* @var $userInfo app\models\Product */

$this->title = 'Оформление заказа завершено';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$products = yii::$app->cart->elements;
//echo '<pre>';
//var_dump(Yii::$app->cart->cart->user_id);
//echo '</pre>';

?>

<div class="order-checkout-finish">

    <h1 class="text-centter"><?= Html::encode($this->title) ?></h1>
    <div><?=$messege?></div>   
    <?=$send?>
</div>