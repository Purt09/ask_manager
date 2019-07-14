<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\user\Module;
use app\modules\user\components\UsersListWidget;

/* @var $this Module\web\View */
/* @var $model module\modules\user\models\User */

$this->title = Module::t('module', 'PROFILE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-6">
    <div class="user-profile">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Module::t('module', 'BUTTON_UPDATE'), ['update'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Module::t('module', 'LINK_PASSWORD_CHANGE'), ['change-password'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Module::t('module', 'SEARCH_USER'), 'profile/search', ['class' => 'btn btn-primary']) ?>
            <?php if ($requests != 0) : ?>
                <?= Html::a('Заявки в друзья(' . $requests . ')', ['request'], ['class' => 'btn btn-warning']) ?>
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
        'limit' => 3,
        'button' =>
            [
                '0' => [
                    'text' => Module::t('module', 'DELETE_FRIEND'),
                    'url' => 'default/delete-friend',
                    'class' => 'btn btn-warning btn-sm',
                    'redirect' => 'profile/index'
                ],
                '1' => [
                    'text' => Module::t('module', 'LOOK_PROFILE'),
                    'url' => 'profile/index',
                    'class' => 'btn btn-success mt-2 btn-sm'
                ],

            ],
        'button_bottom' =>
            [
                'text' => 'Показать всех',
                'url' => 'profile/friend',
                'class' => 'btn btn-info btn-sm',
            ],

    ]) ?>
</div>