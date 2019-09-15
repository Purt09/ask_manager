<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StatyaStatic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statya Statics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statya-static-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <? if (Yii::$app->user->can('Admin')) { ?>    
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    <? } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'updated_at',
            // [       
            //     'attribute' => 'status',
            //     'value' => yii::$app->params['status'][$model->status],
            // ],
            'name',
            [                      // the owner name of the model
                'attribute' => 'url',
                'format' => 'html',
                'value' => Html::a($model->viewUrl(),$model->viewUrl()),
            ],
            'meta_keywords',
            'meta_description',
            'description:html',

            // 'name',
            // 'url:url',
            // 'status',

        ],
    ]) ?>

</div>
