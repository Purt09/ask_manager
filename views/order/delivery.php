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

$this->title = 'Доставка';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$products = yii::$app->cart->elements;
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="//points.boxberry.ru/js/boxberry.js"> </script/>
<script id="ISDEKscript" type="text/javascript" src="https://www.cdek.ru/website/edostavka/template/js/widjet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<div class="order-basket" id="app">
    <h1><?= Html::encode($this->title) ?><span class="pull-right"><? //= TruncateButton::widget(); ?></span></h1>

    Выберите способ доставки: <br>
    <input type="radio" @click="pochta()">
        Почта России <br>
    <input type="radio" @click="sdec = true">
        СДЭК <br>
    <input type="radio" @click="EMS()">
        EMS <br>
    <input type="radio" onclick="boxberry.open(callback_function,'n3wQTUEoRVFDisR7WkyGLw==','Санкт-Петербург','', 0, 1300,
0, 8, 22, 22 ); return false;" >Boxberry

    <modal v-show="sdec" @close="sdec = false">
        <h3 slot="header">Выбор пункта выдачи СДЭК:</h3>
        <div slot="header">
            <button class="btn btn-danger"
                    @click="sdec = false"> Закрыть
            </button>
        </div>
        <div slot="body">
            <div id="forpvz" style="width:100%; height:600px;"></div>
        </div>
        <div slot="footer">
            <button class="btn btn-danger"
                    @click="sdec = false"> Закрыть
            </button>
        </div>
    </modal>
</div>

<p class="text-right h3">
    Итого: <?= CartInformer::widget(['htmlTag' => 'span', 'text' => '{p}']); ?>
</p>

<script type="text/x-template" id="modal-template">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-header">
                        <slot name="header">
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                        </slot>
                    </div>
                </div>
            </div>
        </div>

    </transition>
</script>
<?php
Yii::$app->view->registerJs("var products = " . Json::encode($products)
    . ";", \yii\web\View::POS_END);


$js = <<<JS
var ourWidjet = new ISDEKWidjet({
            defaultCity: 'auto', //какой город отображается по умолчанию
            cityFrom: 'Краснодар', // из какого города будет идти доставка
            country: 'Россия', // можно выбрать страну, для которой отображать список ПВЗ
            link: 'forpvz', // id элемента страницы, в который будет вписан виджет
            path: 'https://www.cdek.ru/website/edostavka/template/scripts/', //директория с бибилиотеками
            servicepath: '/web/SDEC/service.php', //ссылка на файл service.php на вашем сайте
            onChoose: onChoose
          });
          function onChoose(wat) {  
             console.log( wat);
           swal("СДЭК!", "Вы выбрали способ доставки!", "success");
       $.ajax({
         url: '/order/add-delivery-to-cart',
         type: 'GET',
         data: "name=" + 'Доставка товара через СДЭК в город: ' + wat.cityName + ' пункт выдачи: ' + wat.PVZ['Address'] + "&price=" + wat.price + "&description=СДЭК"  + "&city=" + wat.city + '&cityName=' + wat.cityName + '&id=' + wat.id,
         success: function(){
           console.log( wat);
         },
         error: function(){
           console.log( wat);
         }
         });
   }
function callback_function(result){
result.name = encodeURIComponent(result.name) // Что бы избежать проблемы с кириллическими символами, на страницах отличными от UTF8, вы можете использовать функцию encodeURIComponent()
           swal("BoxBerry!", "Вы выбрали способ доставки!", "success");
$.ajax({
         url: '/order/add-delivery-to-cart',
         type: 'GET',
         data: "name=" + 'Доставка товара через Boxberry в город: ' + result.address + "&price=" + result.price + "&description="+ "&city=" + result.name + '&cityName=' + result.name + '&id=' + result.id,
         success: function(){
         },
         error: function(){

         }
         });
if (result.prepaid=='1') {
alert('Отделение работает только по предоплате!');
}
}

Vue.component('modal', {
  template: '#modal-template'
})



new Vue({
el: '#app',
data:{
  sdec: false,
},
methods: {
  pochta(){  
    
           swal("Почта России!", "Вы выбрали способ доставки!", "success");
      $.ajax({
         url: '/order/add-delivery-to-cart',
         type: 'GET',
         data: "name=" + 'Доставка с помощью Почты России стоимость доставки будет изветсна после звонка администратора' + "&price=" + 0 + "&description=" + 'Почту России' + "&city=" + 'code' + '&cityName=' + 'city' + '&id=' + 'test',
         success: function(){
         },
         error: function(){
         },
       })
   },
   EMS(){  
    
           swal("EMS!", "Вы выбрали способ доставки!", "success");
      $.ajax({
         url: '/order/add-delivery-to-cart',
         type: 'GET',
         data: "name=" + 'Доставка с помощью EMS стоимость доставки будет изветсна после звонка администратора' + "&price=" + 0 + "&description=" + ' EMS' + "&city=" + 'code' + '&cityName=' + 'city' + '&id=' + 'test',
         success: function(){
         },
         error: function(){
         },
       })
   },
},
});
         
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>


<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 80%;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>