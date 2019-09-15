<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TextMailTemplate */

$this->title = Yii::t('app', 'Create Text Mail Template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Text Mail Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-mail-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
