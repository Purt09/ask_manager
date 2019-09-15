<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\widgets\VideoEmbed;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Videos');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::t('app', 'Videos').' '.yii::$app->params['mainTitle']]);
$this->registerMetaTag(['name' => 'description', 'content'  => Yii::t('app', 'Videos').' '.yii::$app->params['mainTitle']]);
?>

<div class="video-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php// echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); 
    $dataProvider->query->andWhere(['status' => 1]);
?>
    <div class="row">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'layout' => '<div class="form-group col-md-12">{summary}</div>
                    <div class="col-md-12">{pager}</div>
                    <div class="clearfix">{items}</div>
                    <div class="col-md-12">{pager}</div>',
        'summary' => 'Показано {count} из {totalCount}.',
        'itemView' => function ($model, $key, $index, $widget) {
            //return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
            return '<div class="form-group col-sm-4">'.VideoEmbed::widget(['url' => $model->url]).'</div>';
        },
        'pager' => [
            'class' => 'justinvoelker\separatedpager\LinkPager',
            'maxButtonCount' => 7,
            'prevPageLabel' => false,
            'nextPageLabel' => false,
        ],
    ]) ?>
    </div>
<?php Pjax::end(); ?></div>
