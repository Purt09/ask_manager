<?php

use yii\helpers\Html;
use app\modules\task\Module;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */

$this->title = Module::t('module', 'TASK_CREATE');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'TASKS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
