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
            <div class="col-sm-4 mr-3 border rounded-bottom shadow-sm rounded-lg">
                <div class="row">
                    <div class="p-3  bg-info text-white" >
                        Задачи:
                    </div>
                    <div class="p-3 bg-light rounded-bottom" >
                        <?php for($i=0; $i<count($tasksactive);$i++):  ?>

                            <a href="<?= Url::to(['/task/user/update', 'id' => $tasksactive[$i]->id]) ?>" class="text-body pl-3"> <?= $tasksactive[$i]->title ?> </a>
                            <? echo Html::a('(выполнено)', Url::to(['/task/user/complete', 'id' => $tasksactive[$i]->id]), ['class'=>' text-secondary']) ?>
                        <br>

                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-2 mr-3">
                <div class="row">
                    <div class="p-3  bg-secondary text-white border rounded-bottom shadow-sm rounded-lg" >
                        Просроченные:
                    </div>
                    <div class="p-3 mb-2 bg-light" >
                        <?php for($i=0; $i<count($tasksoverdue);$i++):  ?>

                            <a href="<?= Url::to(['/task/user/update', 'id' => $tasksoverdue[$i]->id]) ?>" class="text-body pl-3"> <?= $tasksoverdue[$i]->title ?> </a>
                            <? echo Html::a('(выполнено)', Url::to(['/task/user/complete', 'id' => $tasksoverdue[$i]->id]), ['class'=>' text-secondary']) ?>
                            <br>

                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 mr-3">
                <div class="row">
                    <div class="p-3 bg-success text-white border rounded-bottom shadow-sm rounded-lg" >
                        Выполненные:
                    </div>
                    <div class="p-3 mb-2 bg-light" >

                        <?php for($i=0; $i<count($taskscomplete);$i++):  ?>

                            <a href="<?= Url::to(['/task/user/update', 'id' => $taskscomplete[$i]->id]) ?>" class="text-body pl-3"> <?= $taskscomplete[$i]->title ?> </a>
                            <? echo Html::a('(невыполнено)', Url::to(['/task/user/uncomplete', 'id' => $taskscomplete[$i]->id]), ['class'=>' text-secondary']) ?>
                            <br>

                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 ">
                <div class="row">
                    <div class="p-3 mb-2 bg-primary text-white border rounded-bottom shadow-sm rounded-lg" >
                        Участники:
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>
