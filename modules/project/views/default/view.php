<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\components\Vardump;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'PROJECTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= $this->title ?></h1>
    <br>

    <div class="container">
        <div class="col-sm-8">
            <div class="mod-row">
                <div class="col-sm-6 mr-3 border rounded-bottom shadow-sm rounded-lg">
                    <div class="row">
                        <div class="p-3  bg-info text-white" >
                            Задачи:
                        </div>
                        <div class="p-3 bg-light rounded-bottom" >
                            <?php foreach ($tasksactive as $task): ?>

                                <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>" class="text-body pl-3"> <?= $task['title'] ?> </a>
                                <?= Html::a('(выполнено)', Url::to(['/task/user/complete', 'id' => $task['id']]), ['class'=>' text-secondary']) ?>
                                <br>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 mr-3 border rounded-bottom shadow-sm rounded-lg">
                    <div class="row">

                    <div class="p-3  bg-secondary text-white " >
                        Просроченные:
                    </div>
                    <div class="p-3 bg-light mod-row" >
                        <?php foreach ($tasksoverdue as $task): ?>

                            <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>" class="text-body pl-3"> <?= $task['title'] ?> </a>
                            <? echo Html::a('(выполнено)', Url::to(['/task/user/complete', 'id' => $task['id']]), ['class'=>' text-secondary']) ?>
                            <br>

                        <?php endforeach; ?>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 mr-3 border rounded-bottom shadow-sm rounded-lg">

                <div class="p-3 mb-2 bg-primary text-white " >
                    Участники:
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="col-sm-12 mr-3 border rounded-bottom shadow-sm rounded-lg">
                <div class="row">
                    <?php foreach ($subprojects as $subproject): ?>
                        <?= \app\modules\project\components\ProjectWidget::widget(['tpl' => 'project', 'id' => $subproject->id]) ?>
                        <?= $subproject->id ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>



    </div>
</div>


