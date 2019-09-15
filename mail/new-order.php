<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $order app\orders\Order */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Заказ #'.$order->id.' на Сайт от '.Yii::$app->formatter->asDate( $order->created_at, 'dd.MM.yyyy');
$orderProducts = $order->getOrderProducts()->all();
$userInfo = @$order->userInfo;
$userInfoArray = unserialize($order->user_info_array);
?>


<div>
    <div style="text-align:left;color:rgb(115,115,115);line-height:150%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;">
        <p style="margin:0px 0px 16px">Благодарим Вас за заказ.
Мы свяжемся с вами в ближайший рабочий день для согласования сроков отправки, 
комплектацию и способа оплаты.</p>
       <!--  <p style="margin:0px 0px 16px">&nbsp;</p> -->
        <h2 style="margin:16px 0px 8px;text-align:left;color:rgb(85,125,161);line-height:130%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;display:block">Номер вашего заказа #<?=$order->id; ?></h2>
        <? if(empty($orderProducts)){
            echo 'Товаров нет';
        } else {
            ?>
        <table style="border:1px solid rgb(228,228,228);width:100%;color:rgb(115,115,115);font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif" border="1" cellpadding="6" cellspacing="0">
            <tbody>
            <tr>
                <th style="padding:12px;border:1px solid rgb(228,228,228);text-align:left;color:rgb(115,115,115)">Товар</th>
                <th style="padding:12px;border:1px solid rgb(228,228,228);text-align:left;color:rgb(115,115,115)">Количество</th>
                <th style="padding:12px;border:1px solid rgb(228,228,228);text-align:left;color:rgb(115,115,115)">Цена</th>
            </tr>
            </tbody>
            <tbody>
                <? 
                $orderProductPrice = 0;
                foreach($orderProducts as $orderProduct){ 
                $orderProductPrice += $orderProduct->count*$orderProduct->price;
                ?>
                <tr>
                    <td style="padding:12px;border:1px solid rgb(238,238,238);text-align:left;color:rgb(115,115,115);font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;vertical-align:middle"><?=$orderProduct->product->name?></td>
                    <td style="padding:12px;border:1px solid rgb(238,238,238);text-align:left;color:rgb(115,115,115);font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;vertical-align:middle"><?=$orderProduct->count;?></td>
                    <td style="padding:12px;border:1px solid rgb(238,238,238);text-align:left;color:rgb(115,115,115);font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;vertical-align:middle">
                        <span><?=$orderProduct->price?>&nbsp;<span>р<span>уб.</span></span></span>
                    </td>
                </tr>
                <?  } ?>
        <tr>
            <th style="padding:12px;border:1px solid rgb(228,228,228);text-align:left;color:rgb(115,115,115)" colspan="2">
            Всего:</th>
            <td style="padding:12px;border:1px solid rgb(228,228,228);text-align:left;color:rgb(115,115,115)">
            <span><?=$orderProductPrice ?>&nbsp;<span>р<span>уб.</span></span></span>
            </td>
        </tr>
            </tbody>
        </table>
        <? } ?>
    </div>
    <h2 style="margin:16px 0px 8px;text-align:left;color:rgb(85,125,161);line-height:130%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;display:block">Ваши данные</h2>
    <div>
        <b>Email:</b> <a href="mailto:<?=$userInfo['email'];?>"><?=$userInfo['email'];?></a><br>
        <b>Тел:</b> <?=$userInfo['telephone_code'].' '.$userInfo['telephone'];?><br>
        <?=$userInfo['surname']?> <?=$userInfo['name']?> <?=$userInfo['patronymic']?><br>
        <?=$userInfo->country->name;?><br>
        <?=$userInfo['address'];?><br>
        <?=$userInfo['postcode'];?><br>
    </div>

    <? if (!empty($order->description)) { ?>
    <p>
        <h2 style="margin:16px 0px 8px;text-align:left;color:rgb(85,125,161);line-height:130%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;display:block"><?=$order->attributeLabels()['description'];?></h2>
        <div style=""><?=$order->description?></div>
    </p>
    <? } ?>

</div>

