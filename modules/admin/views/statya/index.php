<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\StatyaGroup;
/* @var $this yii\web\View */
/* @var $searchModel app\models\StatyaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Statyas');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="statya-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Statya'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'name',
                // 'contentOptions' =>['class' => 'table_class','style'=>'display:block;'],
                'content'=>function($model){
                    return Html::a($model->name, '/admin/statya/update/'.$model->id,['title' => Yii::t('app', 'Update')]) ;
                }
            ],
            [       
                'attribute' => 'status',
                'content'=>function($model){
                    return yii::$app->params['status'][$model->status];
                }
            ],

            [
                'attribute'=>'group_id',
                // 'options' => ['class' => 'text-center','style'=>'width:140px;'],
                'contentOptions' => ['class' => '','style'=>'width:240px;'],
                'content'=>function($model){
                    $statyaGroups = StatyaGroup::find()->all();
                    $statyaGroups = \yii\helpers\ArrayHelper::toArray($statyaGroups);
                    
                    $select = '<select onchange="editStatyaGroup($(this),'.$model->id.'); return false;" name ="group_id" >';
                    $select .= "<option value='0' > - </option>";
                    foreach ($statyaGroups as $key => $value) {
                        if ($model->group_id == $value['id']) {
                            $sel = 'selected';
                        } else {
                            $sel = '';
                        }
                        $select .= "<option value='".$value['id']."' ".$sel.">".$value['name']."</option>";
                    }
                    $select .= "</select>";
                    return $select ;
                }
            ],
            // 'url:url',
            // 'description_min:ntext',
            // 'description:ntext',
            // 'foto',
            // 'meta_keywords',
            // 'meta_description',
            // 'status',
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
