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

    <?/*
    <h1><?//= Html::encode($this->title) ?></h1>
    <?php// echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?//= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    */?>
    
    <form class="form-products-list" method="post">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    <input type="hidden" name="act" value="AddProducts" />

    <div class="form-group">
        <input type="button" value="Добавить" class="form-products-list-submit btn btn-primary btn-sm">
    </div>

    <?if (!empty($messege)) {?>
        <div class="form-group text-primary"><?=$messege?></div>
    <?}?>
    <?if (!empty($error)) {?>
        <div class="form-group text-danger"><?=$error?></div>
    <?}?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-responsive'
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            // [
            //     'attribute'=>'name',
            //     // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
            //     'content'=>function($model){
            //         return Html::a($model->name, '/admin/product/update/'.$model->id,['title' => Yii::t('app', 'Update')]) ;
            //     }
            // ],
            [       
                'attribute' => 'status',
                'content'=>function($model){
                    return yii::$app->params['status'][$model->status];
                }
            ],
            [       
                'attribute' => 'price',
                'contentOptions' =>['class' => 'table_class','style'=>'width:150px;'],
                'content'=>function($model){
                    //return $model->price.' руб.' ;
                    return '<input type="number" style="width:100px;display: inline-block;" class="form-control" name="ProductPrice[]" value="'.$model->price.'"> руб.';
                }
            ],
            [
                //'attribute'=>'name',
                'label' => 'Коли-во',
                'contentOptions' =>['class' => 'table_class','style'=>'width:100px;'],
                'content'=>function($model){
                    return '<input type="hidden" class="form-control" name="ProductId[]" value="'.$model->id.'">
                            <input type="number" class="form-control" name="ProductCount[]" value="1">' ;
                }
            ],
            // [
            //     //'attribute'=>'name',
            //     'label' => '<input name="checkboxProductAll" type="checkbox">',
            //     // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
            //     'content' => function($model){
            //         return '<input name="checkboxProduct['.$model->id.']" type="checkbox">';
            //         // return Html::a(
            //         //     '<input name="checkboxProduct['.$model->id.']" type="checkbox">'
            //         //     //.'<input type="text" class="form-control input-sm" name="Product['.$model->id.']" value="1">'
            //         //     , '/admin/order/add-products/'.$model->id,['class' => 'btn btn-primary btn-sm']) ;
            //     }
            // ],
            //'characteristics:ntext',
            // 'description_min:ntext',
            // 'description:ntext',
            // 'meta_keywords',
            // 'meta_description',
            // 'created_at',
            // 'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\CheckboxColumn',
                // you may configure additional properties here
                // 'checkboxOptions' => function($model, $key, $index, $column) {
                //     return ['checked' => false];
                // },
                'name' => 'ProductCheckbox',
                // 'content' => function($model){
                //     return '<input name="checkboxProduct['.$model->id.']" type="checkbox">';
                //     // return Html::a(
                //     //     '<input name="checkboxProduct['.$model->id.']" type="checkbox">'
                //     //     //.'<input type="text" class="form-control input-sm" name="Product['.$model->id.']" value="1">'
                //     //     , '/admin/order/add-products/'.$model->id,['class' => 'btn btn-primary btn-sm']) ;
                // }
            ],
        ],
        'pager' => [
            'class' => 'justinvoelker\separatedpager\LinkPager',
            'maxButtonCount' => 7,
            'prevPageLabel' => false,
            'nextPageLabel' => false,
        ]
    ]); ?>
    </div>
    </form>
</div>
