<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Video */

$this->title = Yii::t('app', 'Videos').' № '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Videos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [           
                'attribute' => 'url',
                'format' => 'html',
                'value' => Html::a($model->url,$model->url),
            ],
            // 'status',
            [       
                'attribute' => 'status',
                'value' => yii::$app->params['status'][$model->status],
            ],
            'created_at',
            'updated_at',
            [       
                'attribute' => 'view_main',
                'format' => 'html',
                'value' => (!empty($model->view_main)) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>',
            ],
            'sort_main',
        ],
    ]) ?>

</div>
