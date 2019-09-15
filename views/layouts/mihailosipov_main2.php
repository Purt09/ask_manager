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
<div class="header-main-img" onClick="document.location='/'">
    <div class="container">
        <div class="row header-info5">
            <div class="col-xs-6">
                <br>
            </div>
            <div class="col-xs-6 text-right">
<!--                <div class="header-time-work"><i class="fa fa-clock-o"></i> <?=yii::$app->params['time-work']?></div>
                <a class="vk" title="VK" href="http://vk.com/osipov1961" target="_blank" >
                    <i class="fa fa-vk"></i>
                </a>
-->

                <!-- <i class="fa fa-phone" aria-hidden="true"></i> <?=yii::$app->params['telephone']?> -->
                <div class="telephone">
                    <i class="fa fa-clock-o" style="font-weight: normal"></i> <?=yii::$app->params['time-work']?>                
                 <div class="text-right" style="display: inline-block;">
                 <a href="http://vk.com/osipov1961"><img src="/img/logo_vk.png"></a>
                 <a href="https://www.youtube.com/channel/UCiZHAiEP-tU8p39qCllQGpA"><img src="/img/logo_youtube.png"></a>
                 </div>
                    <br />
                    <!--<i class="fa fa-phone" aria-hidden="true"></i> 8 (800) 775-56-39 звонок безплатный
                    <br />-->
                   <i class="fa fa-phone" aria-hidden="true"></i> 8 (800) 775-56-39 звонок безплатный
                    <br>  
                  <i class="fa fa-phone" aria-hidden="true"></i> +7 (918) 250-65-97 МТС
                    <br>
                    <i class="fa fa-phone" aria-hidden="true"></i> +7 (965) 464-26-05 Билайн
                    <br />
                    <i class="fa fa-envelope"></i> <?=yii::$app->params['email-work']?>
                </div><br />
                
            </div>
        </div>
    </div> 
</div>
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
    <nav id="w4" class="navbar navbar-default navbar-fixed-top" role="navigation">
    */

    ?>

    

    <nav id="w4" class="navbar navbar-default navbar-default-mod1" role="navigation">
        <div class="container header3">
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
                <div class="mini-widgets"><span class="mini-contacts email show-on-desktop near-logo-first-switch in-menu-second-switch first">66550@mail.ru</span><span class="mini-contacts clock show-on-desktop near-logo-first-switch in-menu-second-switch last">: </span></div>         <div class="mini-widgets"><div class="soc-ico show-on-desktop near-logo-first-switch hide-on-second-switch custom-bg hover-accent-bg first last"><a title="VK" href="http://vk.com/osipov1961" target="_blank" class="vk" style="visibility: visible;"><svg class="icon" viewBox="0 0 24 24"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#vk"></use></svg></a></div></div>      </div> -->
    
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
                            //['label' => 'Контакты', 'url' => ['/site/contact']],
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
                        <p class="telephone"><i class="fa fa-phone"></i> <?=yii::$app->params['telephone']?> </p>
                        <script type="text/javascript" src="//vk.com/js/api/openapi.js?146"></script>

                        <!-- VK Widget -->
                        <div id="vk_subscribe"></div>
                        <script type="text/javascript">
                        VK.Widgets.Subscribe("vk_subscribe", {soft: 1}, -136445645);
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- <img class="img_vikhrevaya_meditsina" src="\img\vikhrevaya_meditsina.jpg"> -->
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container" >
      <div class="column-left" style="float: left; width: 33%; text-align: center;"><div class="footer-copyright-new">© 2016-2018 "Оздоровительная Катушка Мишина"</div><!--<?=yii::$app->params['footer-copyright']?>--><div itemscope itemtype="http://schema.org/Organization" >
  <span itemprop="name">Вихревая Медицина - Катушки Мишина </span>|<a href="/"> mihailosipov.ru</a></div></div>
<div class="column-center"  style="display: inline-block; width: 33%; text-align: center;">
  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    Адрес:
    <span itemprop="streetAddress">Южная, д. 18</span>,
    <span itemprop="postalCode"> 350007</span>,
    <span itemprop="addressLocality">Краснодар</span>.</div></div>
<div class="column-right" style="float:right; width: 33%; text-align: center;"> Телефон: <span itemprop="telephone"><a href="tel:+7 918 250 65 97">+7 (918) 250 65 97</a></span>, <span itemprop="telephone"><a href="tel:+7 965 464 26 05">+7 (965) 464-26-05</a></span>.
<br/>
  Электронная почта: <a href="mailto:66550@mail.ru"><span itemprop="email">66550@mail.ru</span></a></div>
<!--        <p class="footer-copyright"><?=yii::$app->params['footer-copyright']?></p> -->
       <!--   <p class="footer-copyright"><?=yii::$app->params['footer-copyright']?><br/>
      <div itemscope itemtype="http://schema.org/Organization" style="text-align: center;" >
  <span itemprop="name">Вихревая Медицина - Катушки Мишина | mihailosipov.ru"</span>
    
  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    Адрес:
    <span itemprop="streetAddress">Южная, д. 18</span>,
    <span itemprop="postalCode"> 350007</span>,
    <span itemprop="addressLocality">Краснодар</span>.</div>
       Телефон: <span itemprop="telephone">8 800-775-56-39</span>, <span itemprop="telephone">+7-499-490-42-96</span>.
<br/>
  Электронная почта: <a href="mailto:66550@mail.ru"><span itemprop="email">66550@mail.ru</span></a>
</div><p class="footer-schema"><p class="footer-telephone"> -->
    </div>  
</footer>

<?php $this->endBody() ?>
</body>
  <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45810204 = new Ya.Metrika({ id:45810204, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45810204" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
</html>
<?php $this->endPage() ?>
