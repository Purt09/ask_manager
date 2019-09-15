<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

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
            'created_at',
            'updated_at',
            [       
                'attribute' => 'status',
                'value' => yii::$app->params['status'][$model->status],
            ],
            [       
                'attribute' => 'price',
                'value' => $model->price.' руб.',
            ],
            'name',
            [                      // the owner name of the model
                'attribute' => 'url',
                'format' => 'html',
                'value' => Html::a($model->viewUrl(),$model->viewUrl()),
            ],
            'meta_keywords',
            'meta_description',
            'description_min:html',
            'characteristics:html',
            'description:html',            

        ],
    ]) ?>

</div>
