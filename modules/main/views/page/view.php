<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\HidePage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hide Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="hide-page-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <p>
        <?= $model->code ?>
    </p>

</div>
