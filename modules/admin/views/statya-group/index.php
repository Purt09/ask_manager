<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\StatyaGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Statya Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-mail-template-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Statya Group'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute'=>'sort_main',
                'contentOptions' => ['class' => '','style'=>'width:140px;'],
                'content'=>function($model){
                    return '
                    <a href="#" style="margin-right:5px;" onclick="editSortMainGroup($(this),'.$model->id.'); return false;"><i class="text-primary fa fa-pencil"></i></a>
                    <span class="sort_main">'.$model->sort_main.'</span> 
                    ' ;
                }
            ],
            // 'text_mail:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
