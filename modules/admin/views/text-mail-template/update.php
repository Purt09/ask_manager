<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TextMailTemplate */

$this->title = Yii::t('app', 'Update Text Mail Template: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Text Mail Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="text-mail-template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
