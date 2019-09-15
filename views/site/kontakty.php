<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Оплата';
$this->registerMetaTag(['keywords' => $this->title.' '.yii::$app->params['mainTitle']]);
$this->registerMetaTag(['description' => $this->title.' '.yii::$app->params['mainTitle']]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-kontakty">
    <h1><?= Html::encode($this->title) ?></h1>

        <h3>Наш адрес и контакты:</h3>
        <p>Осипов Михаил Владиленович</p>
        <p>г.Краснодар ул.Южная 18 кв.15</p>
        <p>Тел: +7 (965) 464-26-05</p>
        <p>Эл. почта: 66550@mail.ru</p>
        <p>Skype: michailosipov</p>

        <h3>Оплата</h3>
        <p>Карта Сбербанка: 4276 3000 5077 5900 Михаил Владиленович О.</p>
        <p>Из-за границы: Westen Union, Moneygram, Золотая Корона.</p>



        <h3>Доставка</h3>
        <p>Доставка производится хорошо зарекомендовавшей себя службой доставки СДЭК.</p>
        <p>Заказ доставляется в пункт выдачи, которых множество или прямо в руки по адресу.  Пункты выдачи жми <a href="http://www.edostavka.ru/contacts/city-list.html">сюда</a></p>
        <p>Стоимость доставки до пункта выдачи 500 рублей, до двери 1000 рублей. В Москву посылка идет 3 дня, в другие города 3-7.</p>
        <p>Там, куда нет доставки СДЭК, посылаем Почтой России первым классом. Это тоже очень быстрый и надежный способ доставки.За границу посылаем только Почтой России. Исключение: Белая Русь и Казахский Стан.</p>

</div>
