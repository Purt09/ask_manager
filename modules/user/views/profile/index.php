<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

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
        <section class="box search">
            <form action="<?= Url::to(['profile/search']) ?>" method="get">
            <input type="text" name="search" placeholder="Добавить друга" />
                <?= Html::button('Search', [
                        'class' => 'btn-success btn',
                        'name' => 'submit'
                ] ) ?>
            </form>
        </section>
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