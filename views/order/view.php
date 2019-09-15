<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = Yii::t('app', 'Order').' № '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$userInfo = @$model->userInfo;
$userInfoArray = unserialize($order->user_info_array);

$view = true;

?>
<div class="order-view">
<? if (Yii::$app->user->isGuest) { 
    $view = false;
    ?>
    <div class="text-danger">Доступно для авторизованных пользователей!</div>
<? } ?>
<? if ($view && $model->user_id != Yii::$app->user->identity->id) { 
    $view = false;
    ?>
    <div class="text-danger">Это не Ваш заказ. Нет доступа к этому заказу!</div>
<? } ?>
<? if ($view) { ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?/*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'user_info_id',
            'description:ntext',
            'status',
            'delivery_description:ntext',
            'delivery_price',
            'created_at',
            'updated_at',
        ],
    ]) */
    ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label><?= $model->attributeLabels()['created_at'] ?>:</label> <?=$model->created_at ?>
            </div>
            <div class="form-group">
                <label><?= $model->attributeLabels()['status'] ?>:</label> 
                <?=yii::$app->params['orderStatus'][$model->status]; ?>
            </div>
            <div class="form-group">
                <label><?= $model->attributeLabels()['description'] ?>:</label>
                <div><?=$model->description; ?></div>
            </div>
            <div class="form-group">
                <label><?= $model->attributeLabels()['delivery_price'] ?>:</label> <?=$model->delivery_price; ?> руб.
            </div>
            <div class="form-group">
                <label><?= $model->attributeLabels()['delivery_description'] ?>:</label>
                <div><?=$model->delivery_description; ?></div>
            </div>
            <? if(!empty($model->tracker_number)){?>
            <div class="form-group">
                <strong><?=$model->attributeLabels()['tracker_number'];?>:</strong>
                <strong><?=$model->tracker_number?></strong>
            </div>
            <? } ?>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
            <b>Email:</b> <a href="mailto:<?=$userInfo['email'];?>"><?=$userInfo['email'];?></a>
            </div>
            <div class="form-group">
            <b>Тел:</b> <?=$userInfo['telephone_code'].' '.$userInfo['telephone'];?>
            </div>
            <div class="form-group">
            <b>ФИО:</b> <?=$userInfo['surname']?> <?=$userInfo['name']?> <?=$userInfo['patronymic']?>
            </div>
            <div class="form-group">
            <b><?= $userInfo->attributeLabels()['country_id'] ?>:</b> <?=$userInfo->country->name;?>
            </div>
            <div class="form-group">
            <b><?= $userInfo->attributeLabels()['address'] ?>:</b> <?=$userInfo['address'];?>
            </div>
            <div class="form-group">
            <b><?= $userInfo->attributeLabels()['postcode'] ?>:</b> <?=$userInfo['postcode'];?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <h4>Товары:</h4>
        <? $orderProducts = $model->getOrderProducts()->all();
        if(empty($orderProducts)){
            echo 'Товаров нет';
        } else {
            ?>
        <table class="table table-striped table-order-product">
            <thead>
            <tr>
                <th>Название</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th class="text-right">Сумма</th>
            </tr>
            </thead>
            <tbody>
                <?
                foreach($orderProducts as $orderProduct){ ?>
                    </tr>
                    <td> <b><?=$orderProduct->product->name?></b></td>
                    <td><?=$orderProduct->price.' р.'?></td>
                    <td><?=$orderProduct->count;?></td>
                    <td class="text-right"><?=($orderProduct->count*$orderProduct->price).' р.'?></td>
                    </tr>
                <?  } ?>
            </tbody>
        </table>
        <? } ?>
    </div>
    <p class="text-right h3">
        Итого: <?=$model->price ?> руб.
    </p>

<? } ?>

</div>
