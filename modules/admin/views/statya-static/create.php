<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StatyaStatic */

$this->title = Yii::t('app', 'Create Statya Static');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statya Statics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statya-static-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
