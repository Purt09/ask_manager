<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

use yii\bootstrap\Modal;

use app\models\UserInfo;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = Yii::t('app', 'Order').' №'.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//$userInfo = $model->getUserInfo()->one();
$userInfo = @$model->userInfo;
$userInfoArray = unserialize($order->user_info_array);

?>
<?php
    yii\bootstrap\Modal::begin([
        'header' => Yii::t('app', 'Send mail'),
        'id' => 'modal-send-mail',
        'size' => 'modal-sm',     
    ]);
?>
<?php yii\bootstrap\Modal::end(); ?>
<?
$js = <<<JS
    $('.modal-send-mail-open').on('click', function() {
        $('#modal-send-mail').modal('show')
            .find('.modal-body').html('Письмо отправляется...');
        $('#modal-send-mail').modal('show')
            .find('.modal-body')
            .load($(this).attr('href'));
        return false;
    });
JS;
$this->registerJs($js);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p class="clearfix">
        <span class="pull-left">
            <?= Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?/*= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) */?>
        </span>
        <span class="pull-right">
            <?//= Html::a(Yii::t('app', 'Send mail'), ['send-mail-order', 'id' => $model->id], ['class' => 'modal-send-mail-open btn btn-primary']) ?>
            <?//= Html::a(Yii::t('app', 'Send mail view'), ['see-mail-order-view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </span>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'created_at',
            [       
                'attribute' => 'created_at',
                'value'=> date_format(date_create($model->created_at), 'd-m-Y H:i:s'),
            ],
            // 'updated_at',
            // 'user_id',
            // 'user_info_id',
            [       
                'attribute' => 'status',
                'value'=> yii::$app->params['orderStatus'][$model->status],
            ],
            // [       
            //     // 'attribute' => 'status',
            //     'label' => 'Пользователь',
            //     'value'=> $userInfo->surname.' '.$userInfo->name.' '.$userInfo->patronymic.' , '.$userInfo->country->name,
            // ],
            // [       
            //     'attribute' => 'delivery_id',
            //     'value'=> \yii::$app->params['delivery'][$model->delivery_id]['name'],
            // ],
            [       
                'attribute' => 'delivery_price',
                'value'=> $model->delivery_price.' руб.',
            ],
            'delivery_description:ntext',
            'description:ntext',
            'text_mail:ntext',
            'tracker_number:ntext',
            
            //'description:ntext',
            // [       
            //     'attribute' => 'price',
            //     'value'=>$model->status.' руб.',
            // ],
        ],
    ]) ?>
    <div class="form-group">
        <a href="<?='/admin/user-info/view/'.$model->user_info_id ?>">Редактировать информацию о заказчике</a>
    </div>
    <? /*
    <div class="form-group" style="font-size: 16px;">
        <b>Email:</b> <a href="mailto:<?=$userInfo['email'];?>"><?=$userInfo['email'];?></a><br>
        <b>Тел:</b> <?=$userInfo['telephone'];?><br>
        <?=$userInfo['surname']?> <?=$userInfo['name']?> <?=$userInfo['patronymic']?><br>
        <?=$userInfo->country->name;?><br>
        <?=$userInfo['address'];?><br>
        <?=$userInfo['postcode'];?><br>
        <a href="<?='/admin/user-info/view/'.$model->user_info_id ?>">Редактировать информацию о заказчике</a>
    </div>
    */?>

    <?= DetailView::widget([
        'model' => $userInfo,
        'attributes' => [
            // 'id',
            // 'user_id',
            // 'name',
            // 'surname',
            // 'patronymic',
            [       
                // 'attribute' => 'status',
                'label' => 'Пользователь',
                'value'=> $userInfo->surname.' '.$userInfo->name.' '.$userInfo->patronymic,
            ],
            'email:email',
            [       
                'attribute' => 'telephone',
                // 'label' => 'Пользователь',
                'value'=> $userInfo->telephone_code.' '.$userInfo->telephone,
            ],
            // 'telephone',
            // 'country_id',
            [       
                'attribute' => 'country_id',
                'value' => $userInfo->country->name,
            ],
            'address',
            'postcode',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>
    <div class="form-group">
        <h4>Товары:</h4>
        <? $orderProducts = $model->getOrderProducts()->all();
        if(empty($orderProducts)){
            echo 'Товаров нет';
        } else {
            ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>№ п/п</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th class="text-right">Сумма</th>
            </tr>
            </thead>
            <tbody>
                <? $i = 1;
                foreach($orderProducts as $orderProduct){ ?>
                    <tr>
                    <td><?=$i++?></td>
                    <td><?=$orderProduct->product->name?></td>
                    <td><?=$orderProduct->price.' р.'?></td>
                    <td><?=$orderProduct->count;?></td>
                    <td class="text-right"><?=($orderProduct->count*$orderProduct->price).' р.'?></td>
<!--                     <td><a href="/admin/order-product/delete/<?=$orderProduct->id?>" title="Удалить" aria-label="Удалить" data-pjax="0" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>
                   </td> -->
                    </tr>
                <?  } ?>
            </tbody>
        </table>
        <? } ?>
    </div>
    <p class="text-right h3">
        Итого: <?=$model->price ?> руб.
    </p>

</div>
<style type="text/css">
    .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th{
        width: 40% !important; 
    }
</style>