<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\user\Module;
use yii\widgets\ActiveForm;
use app\modules\user\components\UsersListWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = Yii::t('app', 'TITLE_PROFILE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-6">
    <div class="user-profile">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('app', 'BUTTON_UPDATE'), ['update'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'LINK_PASSWORD_CHANGE'), ['change-password'], ['class' => 'btn btn-primary']) ?>
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
        Друзья:
    </div>
    <?= UsersListWidget::widget([
        'users' => $users,
        'limit' => 3,
        'button' =>
            [
                '0' => [
                    'text' => 'Удалить из друзей',
                    'url' => 'default/delete-friend',
                    'class' => 'btn btn-warning btn-sm',
                    'redirect' => 'profile/index'
                ],
                '1' => [
                    'text' => 'Посмотреть профиль',
                    'url' => 'profile/index',
                    'class' => 'btn btn-success mt-2 btn-sm'
                ],

            ],
    ]) ?>
</div>