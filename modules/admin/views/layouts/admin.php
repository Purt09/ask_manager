<?php

/**
 * @var $content string
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use admin\assets\AppAsset;
use mdm\admin\components\MenuHelper;

AppAsset::register($this);
//cakebake\bootstrap\select\BootstrapSelectAsset::register($this);

//yiister\adminlte\assets\Asset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <?
    yii::$app->params['mainTitle'] = 'Админка | '.yii::$app->params['mainTitle'];
    if (!empty($this->title)) {
        $this->title .= ' | '.yii::$app->params['mainTitle'];
    } else {
        $this->title = yii::$app->params['mainTitle'];
    }
    ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?=yii::$app->params['favicon']?>">
    <?php $this->head() ?>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="<?=Url::home()?>" class="logo">

            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="/img/logoBig_White.png" alt="" style="height:30px;  position:relative; "></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="/img/logo_White.png" alt="" style="height:30px;  position:relative; "></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- User Account Menu -->
                    <li>
                        <a href="/">Сайт</a>
                    </li>
                    <li>
                        <a href="/admin/admin/update/<?=Yii::$app->user->identity->id ?>"><i class="fa fa-user"></i> <?
                        echo Yii::$app->user->identity->username;
                        if (!empty(Yii::$app->user->identity->profile->name)) {
                            echo ' | '.Yii::$app->user->identity->profile->name;
                        }
                        echo ' (id '.Yii::$app->user->identity->id.')';
                        ?></a>
                    </li>
                    <li>
                        <?= Html::beginForm(['/user/logout'], 'post')
                        .Html::submitButton( 'Выйти', ['class' => 'btn btn-primary btn-sm', 'style' => 'margin:10px;'] )
                        .Html::endForm()
                        ?>
                    </li>
                    <li class="dropdown user user-menu hidden">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="<?=\Yii::$app->user->identity->profile->getAvatarUrl(60)?>" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs"><?=Yii::$app->user->identity->profile->name?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="<?=\Yii::$app->user->identity->profile->getAvatarUrl(160)?>" class="img-circle" alt="User Image">
                                <p>
                                    <?=Yii::$app->user->identity->profile->name?>
                                    <small>Участник с <?=Yii::$app->formatter->asDatetime(Yii::$app->user->identity->created_at,'php:F, Y');?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body hidden">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?='/user/admin/update-profile/'.Yii::$app->user->identity->getId() ?>" class="btn btn-default btn-flat">Профиль</a>
                                </div>
                                <div class="pull-right">
                                    <?= Html::beginForm(['/user/logout'], 'post')
                                    .Html::submitButton( 'Выйти', ['class' => 'btn btn-default btn-flat'] )
                                    .Html::endForm()
                                    ?>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel hidden">
                <div class="pull-left image">
                    <img src="<?=\Yii::$app->user->identity->profile->getAvatarUrl(45)?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?=Yii::$app->user->identity->profile->name?></p>
                    <!-- Status -->
                    <? if(Yii::$app->user->isGuest){?>
                        <a href="#"><i class="fa fa-circle text-muted"></i> Online</a>
                    <?} else {?>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    <?}?>
                </div>
            </div>

            <!-- search form (Optional) -->
            <form action="#" method="get" class="sidebar-form hidden">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
                </div>
            </form>
            <!-- /.search form -->

            <!-- Sidebar Menu -->
            <?
//            echo(Url::home());

            // if (Yii::$app->user->can('Admin') 
            //     || Yii::$app->user->can('Manager'))

            $menuItems = [
                ["label" => "Главная", "url" => "/admin/", "icon" => "home"],
            ];

            $menuItems[] = ['label' => 'Магазин',
                'active' => true,
                'url' => '#',
                "icon" => "shopping-cart",
                'items' => [
                    ['label' => 'Заказы', 'url' => ['/admin/order/index']],
                    //['label' => 'Товары в заказах', 'url' => ['/admin/order-product/index']],
                    ['label' => 'Товары', 'url' => ['/admin/product/index']],
                    ['label' => 'Покупатели', 'url' => ['/admin/user-info/index']],
                    ['label' => 'Шаблоны доставок', 'url' => ['/admin/delivery-template/index']],
                    ['label' => 'Шаблоны текста письма', 'url' => ['/admin/text-mail-template/index']],
                ]
            ];
            $menuItems[] = ['label' => 'Пользователи',
                'active' => true,
                'url' => '#',
                "icon" => "users",
                'items' => [
                    ['label' => 'Список польз-лей', 'url' => ['/admin/admin/index']],
                    
                ]
            ];
            $menuItems[] = ['label' => 'Статьи и т.д.',
                'active' => true,
                'url' => '#',
                "icon" => "book",
                'items' => [
                    ['label' => 'Статьи', 'url' => ['/admin/statya/index']],
                    ['label' => 'Группы статей', 'url' => ['/admin/statya-group/index']],
                    ['label' => 'Видео', 'url' => ['/admin/video/index']],
                    ['label' => 'Статичные статьи', 'url' => ['/admin/statya-static/index']],
                    
                ]
            ];
            if (Yii::$app->user->can('Admin')) {
                $menuItems[] = ['label' => 'Настройки',
                    'active' => true,
                    'url' => '#',
                    "icon" => "cogs",
                    'items' => [
                        ['label' => 'Страны', 'url' => ['/admin/country/index']],
                        ['label' => 'Права доступа', 'url' => ['/rbac']],
                    ]
                ];
           }

                

//                ['label' => 'Перенос',
//                    "icon" => "th",
//                    "url" => "#",
//                    'items' => [
//                        ['label' => 'Перенос', 'url' => [Url::home().'old-realty/perenos']],
//                    ]
//                ],

//                ['label' => 'Кэш',
//                    "icon" => "th",
//                    "url" => "#",
//                    'items' => [
//                        [
//                            'label' => 'Очистить',
//                            'url' => [Url::home().'realty/cache-flush'],
//                            'active'=>\Yii::$app->controller->action->id == 'cache-flush'
//                        ],
//                    ]
//                ],
//                [
//                    'active' => true,
//                    "label" => "Widgets",
//                    "icon" => "th",
//                    "url" => "#",
//                    "items" => [
//                        ["label" => "Menu", "url" => [Url::home()."site/menu"]],
//                        ["label" => "Boxes", "url" => [Url::home()."site/boxes"]],
//                        ["label" => "FlashAlert", "url" => [Url::home()."site/flash-alert"]],
//                        ["label" => "Callouts", "url" => [Url::home()."site/callouts"]],
//                    ],
//                ],


//            if (Yii::$app->user->isGuest) {
//                $menuItems[] = ['label' => 'Логин', 'url' => [Url::home().'site/login']];
//            } else {
//                $menuItems[] = '<li>'
//                    . Html::beginForm([Url::home().'site/logout'], 'post')
//                    . Html::submitButton(
//                        'Logout (' . Yii::$app->user->identity->username . ')',
//                        ['class' => 'btn btn-link']
//                    )
//                    . Html::endForm()
//                    . '</li>';
//            }
//             $menuItems_default = [
//                 // ["label" => "Главная", "url" => "/admin/", "icon" => "home"],
// //                ["label" => "Layout", "url" => ["site/layout"], "icon" => "files-o"],
// //                ["label" => "Error page", "url" => ["site/error-page"], "icon" => "close"],
//             ];

//            $menuItems = MenuHelper::getAssignedMenu(Yii::$app->user->id);
//
//            foreach($menuItems as $key => $value){
//                $menuItems[$key]["icon"] = "th";
//            }
           // $menuItems = array_merge ($menuItems_default, $menuItems);


            echo \yiister\adminlte\widgets\Menu::widget(
                [
                    'activateParents'=>true,
                    "items" => $menuItems
//                    "items" => [
//                        ["label" => "Home", "url" => "/", "icon" => "home"],
//                        ["label" => "Layout", "url" => ["site/layout"], "icon" => "files-o"],
//                        ["label" => "Error page", "url" => ["site/error-page"], "icon" => "close"],
//                        [
//                            "label" => "Widgets",
//                            "icon" => "th",
//                            "url" => "#",
//                            "items" => [
//                                ["label" => "Menu", "url" => ["site/menu"]],
//                                ["label" => "Boxes", "url" => ["site/boxes"]],
//                                ["label" => "FlashAlert", "url" => ["site/flash-alert"]],
//                                ["label" => "Callouts", "url" => ["site/callouts"]],
//                            ],
//                        ],
//                        [
//                            "label" => "Badges",
//                            "url" => "#",
//                            "icon" => "table",
//                            "items" => [
//                                [
//                                    "label" => "Default",
//                                    "url" => "#",
//                                    "icon" => "table",
//                                    "badge" => "123",
//                                ],
//                                [
//                                    "label" => "Blue",
//                                    "url" => "#",
//                                    "icon" => "table",
//                                    "badge" => "123",
//                                    "badgeOptions" => [
//                                        "class" => \yiister\adminlte\components\AdminLTE::BG_BLUE,
//                                    ],
//                                ],
//                            ],
//                        ],
//                        [
//                            "label" => "Multilevel",
//                            "url" => "#",
//                            "icon" => "table",
//                            "items" => [
//                                [
//                                    "label" => "Second level",
//                                    "url" => "#",
//                                ],
//                                [
//                                    "label" => "Second level",
//                                    "url" => "#",
//                                    "icon" => "table",
//                                    "items" => [
//                                        [
//                                            "label" => "Default",
//                                            "url" => "#",
//                                        ],
//                                        [
//                                            "label" => "Red",
//                                            "url" => "#",
//                                            "icon" => "table",
//                                        ],
//                                    ],
//                                ],
//                            ],
//                        ],
//                    ],
                ]
            )
            ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
<!--            <h1>-->
<!--                --><?//= Html::encode(isset($this->params['h1']) ? $this->params['h1'] : $this->title) ?>
<!--            </h1>-->
            <?php if (isset($this->params['breadcrumbs'])): ?>
                <?=
                \yii\widgets\Breadcrumbs::widget(
                    [
                        'encodeLabels' => false,
                        'homeLink' => [
                            'label' => new \rmrevin\yii\fontawesome\component\Icon('home') .' '. Yii::t('app', 'Home'),
                            'url' => Yii::$app->homeUrl,
                        ],
                        'links' => $this->params['breadcrumbs'],
                    ]
                )
                ?>
            <?php endif; ?>
        </section>

        <!-- Main content -->
        <section class="content">
            <?= $content ?>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Админка
        </div>
        <!-- Default to the left -->
        <strong><?=yii::$app->params['footer-copyright']?></strong>
    </footer>
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
