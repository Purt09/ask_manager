<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php if (Yii::$app->user->isGuest) { ?>
    <div class="text-danger">Доступно для авторизованных пользователей!</div>
<? } else {
Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'user_id',
            // 'user_info_id',
            'created_at',
            //'description:ntext',
            [       
                'attribute' => 'status',
                'content'=>function($model){
                    return yii::$app->params['orderStatus'][$model->status];
                }
            ],
            [
                'label'=>'',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                'content'=>function($model){
                    return Html::a('Открыть', '/order/view/'.$model->id,['title' => 'Открыть']) ;
                }
            ],
            // 'delivery_description:ntext',
            // 'delivery_price',
            
            // 'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); 
}

?></div>
