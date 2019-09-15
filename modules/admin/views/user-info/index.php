<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Infos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create User Info'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute'=>'id',
                // 'label'=>'ФИО',
                'filterOptions' =>['style'=>'max-width: 60px;'],
                'value' => function ($model) {
                    return $model->id;
                },
                // 'content'=>function($model){
                //     return $model->id;
                // }
            ],
            // 'user_id',
            [
                'attribute'=>'user_id',
                'label'=>'ID польз-ля',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                'content'=>function($model){
                    return (!empty($model->user_id)) ? $model->user_id : 'не зарегистрирован';
                }
            ],
            // [
            //     'label'=>'ФИО',
            //     // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
            //     'content'=>function($model){
            //         return $model->name.' '.$model->surname.' '.$model->patronymic ;
            //     }
            // ],

            'name',
            'surname',
            // 'patronymic',
            'email:email',
            // 'telephone',
            // 'country_id',
            [
                'attribute' => 'country_id',
                // 'label'     => 'Role',
                // 'value' => function ($model) {
                //     return $model->country->name;
                // },
                'content'=>function($model){
                    return $model->country->name;
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'id',
                    \yii\helpers\ArrayHelper::map(\app\models\Country::find()->all(),'id','name'),
                    ['class' => 'form-control', 'prompt' => 'Все']
                )
            ],

            // 'address',
            // 'postcode',
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
