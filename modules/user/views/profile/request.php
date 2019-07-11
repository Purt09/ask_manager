<?php

use app\modules\user\Module;
use app\modules\user\components\UsersWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'REQUESTS';
$this->params['breadcrumbs'][] = $this->title;


?>
    <h1>Заявки в друзья:</h1>
<?= UsersWidget::widget([
    'users' => $users,
    'button' => true,
    'photo_size' => 1,
]) ?>