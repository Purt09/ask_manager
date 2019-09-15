<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Json;

use dvizh\cart\widgets\DeleteButton;
use dvizh\cart\widgets\ChangeCount;
use dvizh\cart\widgets\CartInformer;
use dvizh\cart\widgets\TruncateButton;
use dvizh\cart\widgets\ChangeOptions;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$products = yii::$app->cart->elements;
?>

<? if (empty($products)) { ?>
    <h1><?= Html::encode($this->title) ?></h1>
    Нет товаров в корзине.
<? } else { ?>
    <h1><?= Html::encode($this->title) ?><span class="pull-right"><? //= TruncateButton::widget(); ?></span></h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Название</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th width="40px;"></th>
        </tr>
        </thead>
        <tbody>

        <?
        $i = 1;
        foreach ($products as $product) {
            ?>
            <tr class="basket-product">
                <td>
                    <a href="/product/<?= $product->getModel()->id . '/' . $product->getModel()->url ?>"><b><?= $product->getModel()->name ?></b></a>
                </td>
                <td><?= $product->price . ' р.' ?></td>
                <td><?= ChangeCount::widget(['model' => $product]); ?></td>
                <td><?= DeleteButton::widget(['model' => $product, 'lineSelector' => '.basket-product']); ?></td>
            </tr>
        <? } ?>
        </tbody>
    </table>
    <p class="text-right h3">
        Итого: <?= CartInformer::widget(['htmlTag' => 'span', 'text' => '{p}']); ?>
    </p>
    <p class="text-right">
        <a class="btn btn-primary" href="/order/delivery">Выбрать способ доставки</a>
    </p>

    <script type="text/javascript">

    </script>


<? } ?>
