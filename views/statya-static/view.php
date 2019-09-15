<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StatyaStatic */

$this->title = $model->name;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statya Statics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statya-static-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?/*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'description:ntext',
            'meta_keywords',
            'meta_description',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) */?>

    <?=$model->description?>

</div>
