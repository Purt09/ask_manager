<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Statya */

$this->title = Yii::t('app', 'Create Statya');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statyas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statya-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
