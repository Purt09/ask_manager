<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\task\models\Task;
use app\components\grid\SetColumn;
use kartik\date\DatePicker;
use app\modules\task\Module;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\task\models\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'TASKS');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Module::t('module', 'TASK_CREATE'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attribute2' => 'date_to',
                    'type' => DatePicker::TYPE_RANGE,
                    'separator' => '-',
                    'pluginOptions' => ['format' => 'yyyy-mm-dd']
                ]),
                'attribute' => 'created_at',
                'format' => 'date',
            ],
//            [
//                'filter' => DatePicker::widget([
//                    'model' => $searchModel,
//                    'attribute' => 'date_from',
//                    'attribute2' => 'date_to',
//                    'type' => DatePicker::TYPE_RANGE,
//                    'separator' => '-',
//                    'pluginOptions' => ['format' => 'yyyy-mm-dd']
//                ]),
//                'attribute' => 'updated_at',
//                'format' => 'datetime',
//            ],
            'title',
            'description',
            [
                'class' => SetColumn::className(),
                'filter' => Task::getStatusesArray(),
                'attribute' => 'status',
                'name' => 'statusName',
                'cssCLasses' => [
                    Task::STATUS_CAR => 'success',
                    Task::STATUS_ACTIVE => 'warning',
                    Task::STATUS_TIME_OUT => 'danger',
                ],
            ],
            //'project_id',
            //'context_id',
            //'user_id',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>