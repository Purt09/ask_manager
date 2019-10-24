<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\HidePage */

$this->title = 'Create Hide Page';
$this->params['breadcrumbs'][] = ['label' => 'Hide Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hide-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
