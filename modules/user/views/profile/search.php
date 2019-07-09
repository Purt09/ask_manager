<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\user\Module;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'SEARCH';
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
<?php foreach ($users as $user): ?>
<?= Html::a($user['username'], '/user/profile', ['id' => $user['id']]) ?>
<hr>

<?php endforeach; ?>

