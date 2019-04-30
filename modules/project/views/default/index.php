<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\project\models\Project;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Project'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'time_at:datetime',
            'title',
            'description',
            [
                'attribute' => 'parent_id',
                'filter' => Project::find()->select(['title', 'id'])->indexBy('id')->column(),
                'value' => 'parent.title'

            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
