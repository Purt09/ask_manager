<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\task\Module;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\task\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'TASKS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Module::t('module', 'UPDATE'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Module::t('module', 'DELETE'), ['delete', 'id' => $model->id], [
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
            'created_at:date',
            'updated_at:datetime',
            'title',
            'description',
            [
                'attribute' => 'project_id',
                'value'=> ArrayHelper::getValue($model, 'project.title'),
            ],
            'context_id',
            'user_id',
            'status',
        ],
    ]) ?>

</div>
