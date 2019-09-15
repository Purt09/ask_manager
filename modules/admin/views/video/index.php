<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Videos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Video'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute'=>'url',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                'content'=>function($model){
                    return Html::a($model->url,$model->url);
                }
            ],
            // 'status',
            [       
                'attribute' => 'status',
                'content'=>function($model){
                    return yii::$app->params['status'][$model->status];
                }
            ],
            // 'created_at',
            // 'updated_at',
            [       
                'attribute' => 'view_main',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                'content' => function($model){
                    return (!empty($model->view_main)) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>';
                }
            ],
            //'sort_main',
            [
                'attribute'=>'sort_main',
                // 'options' => ['class' => 'text-center','style'=>'width:140px;'],
                'contentOptions' => ['class' => '','style'=>'width:140px;'],
                'content'=>function($model){
                    return '
                    <a href="#" style="margin-right:5px;" onclick="editSortMainVideo($(this),'.$model->id.'); return false;"><i class="text-primary fa fa-pencil"></i></a>
                    <span class="sort_main">'.$model->sort_main.'</span> 
                    ' ;
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
