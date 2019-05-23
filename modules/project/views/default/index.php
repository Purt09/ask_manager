<?php
/* @var $this yii\web\View */
use app\modules\project\Module;
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\Vardump;

$this->title = Yii::t('app', 'PROJECTS');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">
    <div class="text-center" >
        <div class="col-sm-6">
            <div class="row">
                <? echo Html::a('Создать проект', Url::to('default/create'), ['class'=>'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                456
            </div>
        </div>
    </div>
    <br>
    <hr/>
    <div class="row">
        <?php foreach ($projects as $project) : ?>
        <div class="col-sm-4 text-center">



            <div class="bg-light pb-2">
                <div class="p-3 mb-2 bg-info text-white" >
                    <a href="<?= Url::to(['view', 'id' => $project->id]) ?>" class="text-body pl-3"> <?=  $project->title; ?></a>
                </div>
                <b>
                    <?php for($i=0; $i<count($tasks[$project->id]);$i++):  ?>
                        <br>

                        <a href="<?= Url::to(['/task/user/update', 'id' => $tasks[$project->id][$i]->id]) ?>" class="text-body pl-3"> <?= $tasks[$project->id][$i]->title ?> </a>
                        <? echo Html::a('(выполнено)', Url::to(['/task/user/complete', 'id' => $tasks[$project->id][$i]->id]), ['class'=>' text-secondary']) ?>

                    <?php endfor; ?>
                    <hr/>
                    <p>
                        <? echo Html::a('Добавить задачу', Url::to(['/task/user/complete', 'id' => $tasks[$project->id][$i]->id]), ['class'=>'btn btn-success']) ?>
                    </p>
                </b>
            </div>

        </div>


            <?php endforeach; ?>
        <?php Vardump::vardump($projects); ?>
        </div>
    </div>
</div>
