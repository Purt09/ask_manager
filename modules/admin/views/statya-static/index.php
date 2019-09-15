<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\StatyaStaticSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Statya Statics');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statya-static-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

   <? if (Yii::$app->user->can('Admin')) { ?>    
    <p>
        <?= Html::a(Yii::t('app', 'Create Statya Static'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <? } ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'name',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                'content'=>function($model){
                    return Html::a($model->name, '/admin/statya-static/update/'.$model->id,['title' => Yii::t('app', 'Update')]) ;
                }
            ],
            // [       
            //     'attribute' => 'status',
            //     'content'=>function($model){
            //         return yii::$app->params['status'][$model->status];
            //     }
            // ],
            // 'name',
            // 'url:url',
            // 'description:ntext',
            // 'meta_keywords',
            // 'meta_description',
            // 'status',
            // 'created_at',
            // 'updated_at',

            //['class' => 'yii\grid\ActionColumn'],
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'template' => '{leadView} {leadUpdate}',
            //     'buttons' => [
            //        'leadView' => function ($url, $model) {
            //            $url = Url::to(['/admin/statya-static/view/', 'id' => $model->id]);
            //           return Html::a('<span class="fa fa-eye"></span>', $url, ['title' => 'Постмотреть']);
            //        },
            //        'leadUpdate' => function ($url, $model) {
            //            $url = Url::to(['/admin/statya-static/update/', 'id' => $model->id]);
            //            return Html::a('<span class="fa fa-pencil"></span>', $url, ['title' => 'Обновить']);
            //        },
            //     ],
            // ],

            [
              'class' => 'yii\grid\ActionColumn',
              //'header' => 'Actions',
              'headerOptions' => ['style' => 'color:#337ab7'],
              'template' => '{view} {update} {delete}',
              'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'View'),
                    ]);
                },

                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'Update'),
                    ]);
                },
                'delete' => function ($url, $model) {
                    if (Yii::$app->user->can('Admin')) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('app', 'Delete'),
                        ]);
                    }
                    return '';
                }
                ],
            ],
        ],
        'pager' => [
            'class' => 'justinvoelker\separatedpager\LinkPager',
            'maxButtonCount' => 7,
            'prevPageLabel' => false,
            'nextPageLabel' => false,
        ]
    ]); ?>
<?php Pjax::end(); ?></div>
