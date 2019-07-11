<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\user\Module;
use yii\widgets\ActiveForm;
use app\modules\user\forms\SearchForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = Yii::t('app', 'TITLE_PROFILE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'BUTTON_UPDATE'), ['update'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'LINK_PASSWORD_CHANGE'), ['change-password'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Module::t('module', 'SEARCH_USER'), 'profile/search', ['class' => 'btn btn-primary']) ?>
        <?php if($requests != null) : ?>
            <?= Html::a('Заявки в друзья(' . $requests . ')', ['request'], ['class' => 'btn btn-warning']) ?>
        <?php endif; ?>


    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email',
            'id',
        ],
    ]) ?>

</div>