<?php
/* @var $this \yii\web\View */
/* @var $content string */
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\modules\admin\rbac\Rbac as AdminRbac;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body data-spy="scroll" data-target=".chat">
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'activateParents' => true,
            'items' => array_filter([
                ['label' => Yii::t('app', 'NAV_HOME'), 'url' => ['/main/default/index']],
                ['label' => Yii::t('app', 'NAW_CONTACT'), 'url' => ['/main/contact/index']],
                Yii::$app->user->isGuest ?
                    ['label' => Yii::t('app', 'NAV_SIGNUP'), 'url' => ['/user/default/signup']] :
                    false,
                Yii::$app->user->isGuest ?
                    ['label' => Yii::t('app', 'NAV_LOGIN'), 'url' => ['/user/default/login']] :
                    false,
                Yii::$app->user->can(AdminRbac::PERMISSION_ADMIN_PANEL) ?
                    ['label' => Yii::t('app', 'NAV_ADMIN'), 'items' => [
                        ['label' => Yii::t('app', 'NAV_ADMIN'), 'url' => ['/admin/default/index']],
                        ['label' => Yii::t('app', 'USERS_ADMIN'), 'url' => ['/admin/users']],
                        ['label' => Yii::t('app', 'USERS_ALL_TASKS'), 'url' => ['/admin/tasks']],
                        ['label' => Yii::t('app', 'ADMIN_ALL_PROJECTS'), 'url' => ['/admin/projects']]

                    ]] :
                    false,
                !Yii::$app->user->isGuest ?
                ['label' => Yii::t('app', 'USERS_PROJECTS'), 'url' => ['/project/default']]
                :
                    false,
                !Yii::$app->user->isGuest ?
                ['label' => Yii::t('app', 'USERS_TASKS'), 'url' => ['/task/user']]
                    :
                    false,
                !Yii::$app->user->isGuest ?
                    ['label' => Yii::t('app', 'NAV_PROFILE'), 'items' => [
                        ['label' => Yii::t('app', 'NAV_PROFILE'), 'url' => ['/user/profile/index', 'id' => Yii::$app->user->identity->id]],
                        ['label' => Yii::t('app', 'LOGOUT ({username})', ['username' => Yii::$app->user->identity->username]),
                            'url' => ['/user/default/logout'],
                            'linkOptions' => ['data-method' => 'post']]
                    ]] :
                    false,
            ]),
        ]);
        NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= Yii::$app->name ?></p>
            <p class="pull-right"><?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>