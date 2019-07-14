<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\user\Module;
use app\modules\user\components\UsersListWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = Module::t('module', 'SEARCH');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'PROFILE'), 'url' => ['index','id' => Yii::$app->user->identity->id], 'id' => 3];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="user-search">

    <hr>
    <div class="user-form">

        <?php $form = ActiveForm::begin(['id' => 'profile-search']); ?>
        <table>
            <tr>
                <td>
                    <?= $form->field($model, 'query')->textInput(['class' => 'input'])->label('') ?>
                </td>
                <td>

                    <div class="form-group ml-3">
                        <?= Html::submitButton(Module::t('module', 'SEARCH_USER'), ['class' => 'btn btn-primary']) ?>
                    </div>
                </td>
            </tr>
        </table>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<h1>Результаты поиска:</h1>
<?= UsersListWidget::widget([
    'users' => $users,
    'button' =>
        [
            '0' => [
                'text' => 'Добавить в друзья',
                'url' => 'default/add-request',
                'class' => 'btn btn-success',
                'redirect' => '/user/profile/search'
            ],
    ],
    'photo_size' => 1,
]) ?>

