<?php

use yii\helpers\Html;
use app\modules\task\Module;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */

$this->title = Module::t('module', 'UPDATE: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'TASKS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title];
?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
