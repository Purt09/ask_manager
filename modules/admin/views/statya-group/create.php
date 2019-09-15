<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StatyaGroup */

$this->title = Yii::t('app', 'Create Statya Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statya Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-mail-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
