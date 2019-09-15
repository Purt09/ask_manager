<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dvizh\cart\widgets\DeleteButton;
use dvizh\cart\widgets\ChangeCount;
use dvizh\cart\widgets\CartInformer;
use app\models\Country;

use dektrium\user\models\LoginForm;
use app\models\DeliveryTemplate;

use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $userInfo app\models\Product */

$this->title = 'Оформление заказа';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$products = yii::$app->cart->elements;
//echo '<pre>';
//var_dump(Yii::$app->cart->cart->user_id);
//echo '</pre>';

?>
<div class="order-checkout">

    <h1 class="text-centter"><?= Html::encode($this->title) ?></h1>

    <? if (empty($products)) { ?>
        Нет товаров в корзине.
    <? } else { ?>
        <? if (Yii::$app->user->isGuest) { ?>
            Совершали покупки? <a href="/user/login">Нажмите для авторизации</a>
        <? } ?>

        <?php
        $form = ActiveForm::begin([
            'id' => 'order-checkout-form',
            'enableAjaxValidation' => true,
            // 'enableClientValidation' => false,
        ]);

        // $form = ActiveForm::begin();

        ?>

        <div class="row">
            <div class="col-sm-6">
                <h3>Платежная информация</h3>
                <? //= $form->field($userInfo, 'user_id')->textInput() ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($userInfo, 'surname')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($userInfo, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>

                <?= $form->field($userInfo, 'patronymic')->textInput(['maxlength' => true]) ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($userInfo, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($userInfo, 'telephone')->textInput(['maxlength' => true]) ?>
                        <? //= $form->field($userInfo, 'telephone')->textInput(['maxlength' => true])
                        /*$telephone_code = $form->field($userInfo, 'telephone_code',['options' => ['class' => '','placeholder' => 'код' ],'template' => '{input}'])->input(null, ['placeholder' => 'код']);
                        ?>
                        <?= $form->field($userInfo, 'telephone',['options' => ['class' => 'form-group'],'template' => '{label} <div class="row"><div class="col-xs-4" style="padding-right:3px;">'.$telephone_code.'</div><div class="col-xs-8" style="padding-left:3px;">{input}</div></div>{error}',])->widget(\yii\widgets\MaskedInput::className(), [
                            'mask' => ['(9{3}) 999-99-99'],
                            //'mask' => ['+{0,1}9{1,5} (9{3}) 999-99-99'],
                            // 'mask' => ['9 (999) 9999-99-99'],


                        ])->textInput(['placeholder' => '(___) ___-__-__'])
                        //])->textInput(['placeholder' => '_ (___) ___-__-__'])
                        //->textInput(['placeholder' => $userInfo->getAttributeLabel('telephone')])
                        */ ?>
                    </div>
                </div>

                <? //= $form->field($userInfo, 'country_id')->textInput()
                $arrCountry = Country::find()->all();
                if (!empty($arrCountry)) {
                    $arrCountry = \yii\helpers\ArrayHelper::map($arrCountry, 'id', 'name');
                } else {
                    $arrCountry = [];
                }

                if (empty($userInfo->country_id)) {
                    $userInfo->country_id = 168;
                }
                echo $form->field($userInfo, 'country_id')->textInput()->dropDownList($arrCountry, ['prompt' => '']);

                ?>

                <?= $form->field($userInfo, 'address')->textarea(['rows' => 6]) ?>

                <? //= $form->field($userInfo, 'apartment')->textInput(['maxlength' => true]) ?>

                <? //= $form->field($userInfo, 'city')->textInput(['maxlength' => true]) ?>

                <? //= $form->field($userInfo, 'region')->textInput(['maxlength' => true]) ?>

                <?= $form->field($userInfo, 'postcode')->textInput(['maxlength' => true]) ?>

                <? //= $form->field($userInfo, 'created_at')->textInput() ?>

                <? //= $form->field($userInfo, 'updated_at')->textInput() ?>

                <? if (Yii::$app->user->isGuest && !empty($user) && 1 == 0) { ?>
                    <p class="form-row form-row-wide create-account">
                        <input class="input-checkbox" id="createaccount" type="checkbox" name="createaccount" value="1">
                        <label for="createaccount">Зарегистрировать вас?</label>
                    </p>
                    <div class="form-group form-group-user" style="display: none;">
                        <div class="form-group">
                            Заполнив нижеуказанные поля, можно создать постоянный профиль на нашем сайте. Если вы уже
                            совершали покупки у нас и регистрировались ранее, то вы можете авторизоваться, заполнив поле
                            логина и пароля наверху.
                        </div>

                        <?= $form->field($user, 'email') ?>

                        <?= $form->field($user, 'username') ?>

                        <?php // if ($module->enableGeneratingPassword == false): ?>
                        <?= $form->field($user, 'password')->passwordInput() ?>
                        <?php // endif ?>
                    </div>
                <? } ?>

            </div>
            <div class="col-sm-6" >
                <h3>Дополнительная информация</h3>
                <div class="form-group">
                    <?
                    $deliveryTemplates = DeliveryTemplate::find()->all();
                    $deliveryName = [];
                    foreach ($deliveryTemplates as $key => $value) {
                        $deliveryName[] = $value->name;
                    }
                    ?>

                    <?php
                    $elements = yii::$app->cart->elements;
                    foreach ($elements as $element){
                        if($element['model'] == 'app\models\Delivery')
                            $test = \app\models\Delivery::FindOne($element['item_id']);
                    }
                  ?>
                    <label>Cпособ доставки: <?= $test['name'] ?></label>
                    <div class="">Свои пожелания по выбору способа доставки и другим вопросам, можете написать в
                        "<?= $order->attributeLabels()['description'] ?>".
                    </div>

                    <?
                    // $arrDelivery = \yii\helpers\ArrayHelper::map(yii::$app->params['delivery'],'id','name');
                    // echo $form->field($order, 'delivery_id')->textInput()->dropDownList($arrDelivery, ['prompt' => 'Выбирите доставку']);
                    ?>
                </div>
                <div class="form-group">
                    <?= $form->field($order, 'description')->textarea(['rows' => 6]) ?>
                </div>
                <small><? //=yii::$app->params['delivery_text1'] ?></small>




            </div>

        </div>

        <h3>Ваш заказ</h3>
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
            foreach ($products as $product) {
//                echo '<pre>';
//                var_dump( $product);
//                echo '</pre>';
                ?>
                </tr>
                <td><b><?= $product->getModel()->name ?></b></td>
                <td><?= $product->price . ' р.' ?></td>
                <td><?= $product->count . ' шт.' ?></td>
                <td class="text-right"><?= ($product->count * $product->price) . ' р.' ?></td>
                </tr>
            <? } ?>
            </tbody>
        </table>

        <p class="text-right h3">
            Итого: <?= CartInformer::widget(['htmlTag' => 'span', 'text' => '{p}']); ?>
        </p>
        <p class="clearfix btn-order-checkout">
            <?= Html::submitButton('Подтвердить заказ', ['class' => 'btn btn-primary pull-right']) ?>
            <a class="btn btn-default pull-left" href="/order/basket">Назад в корзину</a>
        </p>

        <?php ActiveForm::end(); ?>
    <? } ?>
    <div class="form-group-user-cach"></div>

</div>

    </div>