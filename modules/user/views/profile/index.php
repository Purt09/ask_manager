<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\user\Module;
use app\modules\user\components\UsersListWidget;

/* @var $this Module\web\View */
/* @var $model module\modules\user\models\User */

$this->title = Module::t('module', 'PROFILE');
$this->params['breadcrumbs'][] = $this->title;
$hide = true;    //Только чтобы фильтровть данные в виджете, котрый ниже
?>
<div class="col-md-6">
    <div class="user-profile text-center">

        <h1><?= Html::encode($this->title) ?></h1>


        <?php
        if ($model->id == Yii::$app->user->identity->id) :
        $hide = false//Только чтобы фильтровть данные в виджете, котрый ниже
        ?>
        <p>
            <?= Html::a(Module::t('module', 'BUTTON_UPDATE'), ['update'], ['class' => 'btn btn-primary mt-1']) ?>
            <?= Html::a(Module::t('module', 'LINK_PASSWORD_CHANGE'), ['change-password'], ['class' => 'btn btn-primary mt-1']) ?>
            <?= Html::a(Module::t('module', 'SEARCH_USER'), 'profile/search', ['class' => 'btn btn-primary mt-1']) ?>
            <?php if ($requests != 0) : ?>
                <?= Html::a('Заявки в друзья(' . $requests . ')', ['request'], ['class' => 'btn btn-warning mt-1']) ?>
            <?php endif; ?>
            <?php endif; ?>


        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'username',
                'email',
                'phone',
                'first_name',
                'last_name',
                'id',
            ],
        ]) ?>

    </div>
</div>
<div class="col-md-5">
    <div class="p-3 mb-2 bg-info text-white row shadow ">
        <?= Module::t('module', 'FRIENDS') ?>: (<?= count($users) ?>)
    </div>
    <?= UsersListWidget::widget([
        'users' => $users,
        'button_link_profile' => true,
    ]) ?>
</div>