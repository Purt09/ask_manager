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
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?//= Html::a(Yii::t('app', 'Создать заказ'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); 
//$dataProvider->query->andWhere(['between','price_value', 1*$request['fromPrice'], 1*$request['toPrice'] ]);
$dataProvider->query->orderBy(['id' => SORT_DESC ]);
?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'user_id',
            // [       
            //     'attribute' => 'user_id',
            //     'content'=>function($model){
            //         return $model->getUser()->username.' (id '.$model->user_id.' )';
            //     }
            // ],
            // 'user_info_id',
            [       
                // 'attribute' => 'user_info_id',
                'label' => 'Фио',
                'content'=>function($model){
                    return $model->userInfo->surname.' '.$model->userInfo->name.' '.$model->userInfo->patronymic;
                }
            ],
            [       
                // 'attribute' => 'user_info_id',
                'label' => 'Город',
                'content'=>function($model){
                    return $model->userInfo->country->name;
                }
            ],
            // 'description:ntext',
            [       
                'attribute' => 'price',
                'content'=>function($model){
                    return $model->price.' руб.' ;
                }
            ],
            // [       
            //     'attribute' => 'delivery_id',
            //     'content'=>function($model){
            //         return yii::$app->params['delivery'][$model->delivery_id]['name'];
            //     }
            // ],
            [       
                'attribute' => 'status',
                'content'=>function($model){
                    return yii::$app->params['orderStatus'][$model->status];
                }
            ],
            // 'delivery_description:ntext',
            // 'delivery_price',
            // 'created_at',
            [       
                'attribute' => 'created_at',
                'content'=>function($model){
                    return date_format(date_create($model->created_at), 'd-m-Y H:i:s');
                }
            ],
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
