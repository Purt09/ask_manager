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

            <?= \app\modules\project\components\ProjectWidget::widget(['tpl' => 'project', 'id' => $project->id]) ?>

            <?php endforeach; ?>
        </div>
    </div>
</div>

