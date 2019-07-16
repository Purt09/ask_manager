<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\user\Module;
use app\modules\user\components\UsersListWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = Module::t('module', 'FRIENDS');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'PROFILE'), 'url' => ['index','id' => Yii::$app->user->identity->id], 'id' => 3];
$this->params['breadcrumbs'][] = $this->title;
if ($model->id != Yii::$app->user->identity->id) $hide = true;

?>


<h1>Ваши друзья:</h1>
<?= UsersListWidget::widget([
    'users' => $users,
    'photo_size' => 1,
    'button' =>
        [
            '0' => [
                'text' => Module::t('module', 'DELETE_FRIEND'),
                'url' => 'default/delete-friend',
                'class' => 'btn btn-warning',
                'redirect' => 'profile/index',
                'hide' => $hide,

            ],
            '1' => [
                'text' => Module::t('module', 'LOOK_PROFILE'),
                'url' => 'profile/index',
                'class' => 'btn btn-success mt-2'
            ],
        ],
]) ?>

