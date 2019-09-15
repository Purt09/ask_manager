    <?php

    use yii\helpers\Html;
    use yii\helpers\Url;

    use yii\widgets\ActiveForm;
    use app\models\OrderProduct;
    use app\models\DeliveryTemplate;
    use app\models\TextMailTemplate;
    use yii\widgets\DetailView;
    use yii\bootstrap\Modal;

    /* @var $this yii\web\View */
    /* @var $model app\models\Order */
    /* @var $form yii\widgets\ActiveForm */
    $userInfo = @$model->userInfo;
    $userInfoArray = unserialize($order->user_info_array);
    ?>

    <div class="order-form">

        
        <?/*
        <div class="form-group">
            Дата создания: <?=$model->created_at; ?>
            <? if(!empty($model->updated_at)){ ?>
                / Дата обновления: <?=$model->updated_at; ?>
            <?}?>
        </div>
        */?>


        <?php
        $userInfo = $model->getUserInfo()->one();

        $form = ActiveForm::begin(); ?>

        <input type="hidden" name="order_id" value="<?=$model->id?>">


        <div class="form-group">
            <a class="btn btn-primary" href="/admin/order/view/<?=$model->id?>"><?=Yii::t('app', 'Go to view order')?></a>
            <?//= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?
            if ($model->isNewRecord) {
                echo Html::submitButton( Yii::t('app', 'Create'), ['class' => 'btn btn-primary']);
            }
            ?>
        </div>


        <?= $form->field($model, 'created_at')
        ->textInput()
        ->widget(\yii\widgets\MaskedInput::className(), [
            'mask' => '99-99-9999 99:99:99',
        ]);

        ?>

        <?= $form->field($model, 'status')->textInput()->dropDownList(yii::$app->params['orderStatus']) ?>

        <?/*
        <div class="form-group">
            <label>Пользователь</label>
            <?= $userInfo->surname.' '.$userInfo->name.' '.$userInfo->patronymic.' , '.$userInfo->country->name ?>
        </div>
        */?>


        <? /*?>
        <a href="<?=Url::home().'user/view/'.$model->user_id ?>">fgn<?//=$model->getUser()->username; ?></a>
        <?= $form->field($model, 'user_id')->textInput() ?>
        
        
        
        <a href="<?='/admin/user-info/view/'.$model->user_info_id ?>">Инф. заказа польз-я id <?=$model->user_info_id; ?></a>
        <?= $form->field($model, 'user_info_id')->textInput() ?>
        <? */?>
        <div class="form-group">
            <label><?=$model->attributeLabels()['description'];?></label>
            <div class=""><?= $model->description ?></div>
        </div>

        <?//= $form->field($model, 'description')->label('Текст письма')->textarea(['rows' => 6]) ?>

        <?
        /*
        // $arrDelivery = \yii\helpers\ArrayHelper::map(yii::$app->params['delivery'],'id','name');
        // echo $form->field($model, 'delivery_id')->textInput()->dropDownList($arrDelivery, ['prompt' => 'Выбирите доставку']); 
    
        <div class="form-group">
        <small><?=yii::$app->params['delivery_text1'] ?></small>
        </div>
*/
        $TextMailTemplates = TextMailTemplate::find()->all();
        $json_TextMailTemplates = \yii\helpers\ArrayHelper::toArray($TextMailTemplates);
        $cach = [];
        foreach ($json_TextMailTemplates as $key => $value) {
            $cach[$value['id']] = $value;
        }
        $json_TextMailTemplates = $cach;
        unset($cach);
        //echo json_encode($json_TextMailTemplates);
        ?>

        <script type="text/javascript">
            var TextMailTemplates = <?=json_encode($json_TextMailTemplates)?>
        </script>
        <div class="form-group">
            <label><?=yii::t('app', 'Text Mail Templates')?></label>
            <div>
                <?php foreach ($TextMailTemplates as $key => $TextMailTemplate): ?>
                    <button class="btn btn-primary" TextMailTemplates="<?=$TextMailTemplate->id?>"><?=$TextMailTemplate->name?></button>           
                <?php endforeach ?>
            </div>
        </div>

        <?= $form->field($model, 'text_mail')->label('Текст письма')->textarea(['rows' => 6]) ?>

        <?
        /*
        // $arrDelivery = \yii\helpers\ArrayHelper::map(yii::$app->params['delivery'],'id','name');
        // echo $form->field($model, 'delivery_id')->textInput()->dropDownList($arrDelivery, ['prompt' => 'Выбирите доставку']); 
    
        <div class="form-group">
        <small><?=yii::$app->params['delivery_text1'] ?></small>
        </div>
*/
        $deliveryTemplates = DeliveryTemplate::find()->all();
        $json_deliveryTemplates = \yii\helpers\ArrayHelper::toArray($deliveryTemplates);
        $cach = [];
        foreach ($json_deliveryTemplates as $key => $value) {
            $cach[$value['id']] = $value;
        }
        $json_deliveryTemplates = $cach;
        unset($cach);
        //echo json_encode($json_deliveryTemplates);
        ?>

        <script type="text/javascript">
            var deliveryTemplates = <?=json_encode($json_deliveryTemplates)?>
        </script>
        <div class="form-group">
            <label><?=yii::t('app', 'Delivery Templates')?></label>
            <div>
                <?php foreach ($deliveryTemplates as $key => $deliveryTemplate): ?>
                    <button class="btn btn-primary" deliveryTemplates="<?=$deliveryTemplate->id?>"><?=$deliveryTemplate->name?></button>           
                <?php endforeach ?>
            </div>
        </div>
        
        <?= $form->field($model, 'delivery_price')->textInput(['type' => 'number','onchange'=>'order_calc('.$model->id.')','min'=>'0']) ?>

        <?= $form->field($model, 'delivery_description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'tracker_number')->textInput() ?>

        <?//= $form->field($model, 'updated_at')->textInput() ?>
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


<?
// $js = <<<JS
//     $('.open-modal-products-list').on('click', function() {
//         $('#modal-products-list').modal('show')
//             .find('.modal-body').html('Подождите...');
//         $('#modal-products-list').modal('show')
//             .find('.modal-body')
//             .load($(this).attr('href'));
//         return false;
//     });
//     $('#modal-products-list').on('click','[href*=""]', function() {
//         $('#modal-products-list').modal('show')
//             .find('.modal-body')
//             .load($(this).attr('href'));
//     });
// JS;
// $this->registerJs($js);
?>
    <?= Html::a(Yii::t('app', 'Add Products'), ['products-list', 'order_id' => $model->id], ['order_id' => $model->id,'class' => 'btn btn-primary open-modal-products-list']) ?>
    <div class="view-odrer-products-list">
    <? include '_view-odrer-products-list.php'; ?>
    </div>

    <p class="text-right h3">
        Итого: <span class="order_itogo"><?=$model->price ?></span> руб.
    </p>
    <div class="form-group">
        <?//= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?
        if (!$model->isNewRecord) {
            echo Html::Button( Yii::t('app', 'Save'), ['class' => 'btn btn-primary save_order']);
            echo Html::Button( Yii::t('app', 'Save and send email'), ['class' => 'btn btn-primary save_and_end_email','style' => 'margin-left:3px;']);
            // echo Html::a(Yii::t('app', 'Save and send email'), ['see-send-email', 'id' => $model->id], ['class' => 'btn btn-primary save_and_end_email']);
        } else {
            Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ;
        }
        ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<?php
    yii\bootstrap\Modal::begin([
        'header' => Yii::t('app', 'Add Products'),
        'id' => 'modal-products-list',
        'size' => 'modal-lg',     
    ]);
?>
<?php yii\bootstrap\Modal::end(); ?>
<?php
    yii\bootstrap\Modal::begin([
        'header' => Yii::t('app', 'Save and send email'),
        'id' => 'modal_save_and_end_email',
        'size' => 'modal-sm',     
    ]);
?>
<?php yii\bootstrap\Modal::end(); ?>
<?php
    yii\bootstrap\Modal::begin([
        'header' => Yii::t('app', 'Save'),
        'id' => 'modal_save_order',
        'size' => 'modal-sm',     
    ]);
?>
<?php yii\bootstrap\Modal::end(); ?>
