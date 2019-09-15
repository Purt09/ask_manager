<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

use dvizh\cart\widgets\TruncateButton;
use dvizh\cart\widgets\CartInformer;

AppAsset::register($this);
//cakebake\bootstrap\select\BootstrapSelectAsset::register($this);
if (!empty($_SESSION['tmp_user_id']) && !empty($_SESSION['__id'])) {
    $cart_summ = Yii::$app->runAction('order/login-set-cart');
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta property="og:title" content="Вихревая Медицина - Катушки Мишина | mihailosipov.ru"/>
<meta property="og:description" content="Вихревая Медицина - Катушки Мишина. Продажа комплектов и элементов для катушек Мишина | mihailosipov.ru"/>
<meta property="og:url" content= "mihailosipov.ru" />
<meta property="og:image" content="http://mihailosipov.ru/files/gallery/product//1/117/original.jpg?_=1250418412">
<meta property="og:type" content="article"/>
    <?= Html::csrfMetaTags() ?>
    <?
    if (!empty($this->title)) {
        $this->title .= ' | '.yii::$app->params['mainTitle'];
    } else {
        $this->title = yii::$app->params['mainTitle'];
    }
    ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?=yii::$app->params['favicon']?>">
    <?php $this->head() ?>
    <script id="ISDEKscript" type="text/javascript" src="https://www.cdek.ru/website/edostavka/template/js/widjet.js"></script>
</head>
<body class="mihailosipov_main">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
/*
    NavBar::begin([
        'brandLabel' => yii::$app->params['brandLabel'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-default navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [

            ['label' => 'Главная', 'url' => ['/site/index']],
            ['label' => 'Статьи', 'url' => ['/statya/index']],
            //['label' => 'О нас', 'url' => ['/site/about']],
            //['label' => 'Контакты', 'url' => ['/site/contact']],
            ['label' => 'Товары', 'url' => ['/product/index']],
            ['label' => 'Оплата', 'url' => ['/site/kontakty']],

//            Yii::$app->user->isGuest ? (
//                ['label' => 'Login', 'url' => ['/site/login']]
//            ) : (
//                '<li>'
//                . Html::beginForm(['/site/logout'], 'post')
//                . Html::submitButton(
//                    'Logout (' . Yii::$app->user->identity->username . ')',
//                    ['class' => 'btn btn-link logout']
//                )
//                . Html::endForm()
//                . '</li>'
//            )
//            Yii::$app->user->isGuest ?
//                ['label' => 'Sign in', 'url' => ['/user/security/login']] :
//                ['label' => 'Sign out (' . Yii::$app->user->identity->username . ')',
//                    'url' => ['/user/security/logout'],
//                    'linkOptions' => ['data-method' => 'post']],
//            ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest]
            Yii::$app->user->isGuest ?
                ['label' => 'Вход', 'url' => ['/user/security/login']] :
                ['label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/user/security/logout'],
                    'linkOptions' => ['data-method' => 'post']],
            ['label' => 'Регистрация', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],
//            ['label' =>  Html::text(CartInformer::widget(['htmlTag' => 'a', 'offerUrl' => '/?r=cart', 'text' => '{c} на {p}'])),
//                'url' => ['/cart/'],
//            ]
            //'<li>'.CartInformer::widget(['htmlTag' => 'a', 'offerUrl' => '/cart/', 'text' => '{c} товар(ов) {p}']).'</li>'
            '<li>'.CartInformer::widget(['htmlTag' => 'a', 'offerUrl' => '/order/basket/', 'text' => '<i class="fa fa-shopping-cart"></i> {c} товар(ов) {p}']).'</li>'


        ],
    ]);
    NavBar::end();
    */

    ?>

    <!-- <nav id="w4" class="navbar navbar-default navbar-fixed-top" role="navigation"> -->
    <nav id="w4" class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="row header-info1">
                <div class="col-xs-11">
                    <div class="header-email"><i class="fa fa-envelope"></i> <?=yii::$app->params['email-work']?></div>
                    <div class="header-time-work"><i class="fa fa-clock-o"></i> <?=yii::$app->params['time-work']?></div>
                </div>
                <div class="col-xs-1 text-right">
                    <a class="vk" title="VK" href="http://vk.com/osipov1961" target="_blank" >
                        <i class="fa fa-vk"></i>
                       <!--  <span class="fa-stack fa-dm">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-vk fa-stack-1x fa-inverse"></i>
                        </span> -->
                    </a>
                </div>
            </div>
            <div class="header-info2">
                <div class="row">
                    <div class="col-xs-2">
                       <!--  <div class="navbar-header" style="float:left;">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w4-collapse">
                            <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div> -->
                        <div id="nav-icon2"  data-toggle="collapse" data-target="#w4-collapse">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="col-xs-9 col-sm-7 header-logo-img">
                        <a href="/"><img src="/img/logo.png"></a>
                    </div>
                    <div class="col-xs-3 text-right header-telephone"><?=yii::$app->params['telephone']?></div>
                </div> 
            </div>
        </div>
        <div class="container header-logo">

          <!--   <div class="top-bar line-content">
                <div class="mini-widgets"><span class="mini-contacts email show-on-desktop near-logo-first-switch in-menu-second-switch first">66550@mail.ru</span><span class="mini-contacts clock show-on-desktop near-logo-first-switch in-menu-second-switch last">Время работы: 09:00 - 19:00</span></div>         <div class="mini-widgets"><div class="soc-ico show-on-desktop near-logo-first-switch hide-on-second-switch custom-bg hover-accent-bg first last"><a title="VK" href="http://vk.com/osipov1961" target="_blank" class="vk" style="visibility: visible;"><svg class="icon" viewBox="0 0 24 24"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#vk"></use></svg></a></div></div>      </div> -->
    
            <div id="w4-collapse" class="collapse navbar-collapse text-center">
                <div class="shadow-box" onclick="$('#nav-icon2').click();"></div>
                <div class="navbar-box">
                <? echo Nav::widget([
                        'options' => [
                        'id' => 'w5',
                        'class' => 'navbar-nav',
                        ],
                        'items' => [

                            ['label' => 'Главная', 'url' => ['/site/index']],
                            ['label' => 'Статьи', 'url' => ['/statya/index']],
                            //['label' => 'О нас', 'url' => ['/site/about']],
                            ['label' => 'Контакты', 'url' => ['/site/contact']],
                            ['label' => 'Видео', 'url' => ['/video/index']],
                            ['label' => 'Товары', 'url' => ['/product/index']],
                            ['label' => 'Вопросы и ответы', 
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Рак', 'url' => ['/statya-static/2/rak']],
                                    ['label' => 'Остальные болезни', 'url' => ['/statya-static/3/ostalnye_bolezni']],
                                ]
                            ],
                            ['label' => 'Контакты', 'url' => ['/statya-static/1/oplata']],

                //            Yii::$app->user->isGuest ? (
                //                ['label' => 'Login', 'url' => ['/site/login']]
                //            ) : (
                //                '<li>'
                //                . Html::beginForm(['/site/logout'], 'post')
                //                . Html::submitButton(
                //                    'Logout (' . Yii::$app->user->identity->username . ')',
                //                    ['class' => 'btn btn-link logout']
                //                )
                //                . Html::endForm()
                //                . '</li>'
                //            )
                //            Yii::$app->user->isGuest ?
                //                ['label' => 'Sign in', 'url' => ['/user/security/login']] :
                //                ['label' => 'Sign out (' . Yii::$app->user->identity->username . ')',
                //                    'url' => ['/user/security/logout'],
                //                    'linkOptions' => ['data-method' => 'post']],
                //            ['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest]

                            // ['label' => 'Регистрация', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],
                //            ['label' =>  Html::text(CartInformer::widget(['htmlTag' => 'a', 'offerUrl' => '/?r=cart', 'text' => '{c} на {p}'])),
                //                'url' => ['/cart/'],
                //            ]
                            //'<li>'.CartInformer::widget(['htmlTag' => 'a', 'offerUrl' => '/cart/', 'text' => '{c} товар(ов) {p}']).'</li>'
                            '<li>'.CartInformer::widget(['htmlTag' => 'a', 'offerUrl' => '/order/basket/', 'text' => '<i class="fa fa-shopping-cart"></i> {c} товар(ов) {p}']).'</li>',
                            Yii::$app->user->isGuest ?
                                ['label' => 'Вход', 'url' => ['/user/security/login']] :
                                ['label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                                    'url' => ['/user/security/logout'],
                                    'linkOptions' => ['data-method' => 'post']],


                        ],
                    ]);
                ?>
                    <div class="header-navbar-info">
                        <div class="header-email"><i class="fa fa-envelope"></i> <?=yii::$app->params['email-work']?></div>
                        <div class="header-time-work"><i class="fa fa-clock-o"></i> <?=yii::$app->params['time-work']?></div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <img class="img_vikhrevaya_meditsina" src="\img\vikhrevaya_meditsina.jpg">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="footer-copyright"><?=yii::$app->params['footer-copyright']?><!--<br/><div itemscope itemtype="http://schema.org/Organization" style="text-align: center;" >
  <span itemprop="name">Вихревая Медицина - Катушки Мишина | mihailosipov.ru"</span>--></p>
     <!-- <p class="footer-schema">
  Контакты:
  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    Адрес:
    <span itemprop="streetAddress">Южная, д. 18</span>,
    <span itemprop="postalCode"> 350007</span>,
    <span itemprop="addressLocality">Краснодар</span>.</div>
<br/>
  Телефон: <span itemprop="telephone">8 800-775-56-39</span>, <span itemprop="telephone">+7-499-490-42-96</span>.
<br/>
  Электронная почта: <a href="mailto:66550@mail.ru"><span itemprop="email">66550@mail.ru</span></a>
</div>-->
        <p class="footer-telephone"><?=yii::$app->params['telephone']?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
