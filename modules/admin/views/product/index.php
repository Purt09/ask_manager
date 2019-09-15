<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        // 'tableOptions' => [
        //     'class' => 'table table-striped table-bordered'
        // ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'sort_main',
                // 'options' => ['class' => 'text-center','style'=>'width:140px;'],
                'contentOptions' => ['class' => '','style'=>'width:140px;'],
                'content'=>function($model){
                    return '
                    <a href="#" style="margin-right:5px;" onclick="editSortMain($(this),'.$model->id.'); return false;"><i class="text-primary fa fa-pencil"></i></a>
                    <span class="sort_main">'.$model->sort_main.'</span> 
                    ' ;
                }
            ],
            [
                'attribute'=>'name',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                'content'=>function($model){
                    return Html::a($model->name, '/admin/product/update/'.$model->id,['title' => Yii::t('app', 'Update')]) ;
                }
            ],
            [       
                'attribute' => 'price',
                'content'=>function($model){
                    return $model->price.' руб.' ;
                }
            ],
            [       
                'attribute' => 'status',
                'content'=>function($model){
                    return yii::$app->params['status'][$model->status];
                }
            ],
            //'characteristics:ntext',
            // 'description_min:ntext',
            // 'description:ntext',
            // 'meta_keywords',
            // 'meta_description',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'pager' => [
            'class' => 'justinvoelker\separatedpager\LinkPager',
            'maxButtonCount' => 7,
            'prevPageLabel' => false,
            'nextPageLabel' => false,
        ]
    ]); ?>
<?php Pjax::end(); ?></div>
