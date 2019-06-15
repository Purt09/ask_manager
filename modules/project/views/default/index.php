<?php
/* @var $this yii\web\View */
use app\modules\project\Module;
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\project\components\CreateProjectWidget;

$this->title = Yii::t('app', 'PROJECTS');
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="container">
    <div class="text-center" >
        <div class="col-sm-6">
            <div class="row">
                <?= Html::button(Module::t('module', 'PROJECT_CREATE'), ['data-toggle' => 'modal', 'data-target' => '#CreateProject', 'class' => 'btn-success btn']) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">

                <? echo Html::a('Завершенные проекты', Url::to('default/create'), ['class'=>'btn btn-warning']) ?>
            </div>
        </div>
    </div>
    <br><br>
    <hr/>
    <div class="row">
        <?php foreach ($projects as $project) : ?>
        <div class="col-sm-4 ">
            <?= \app\modules\project\components\ProjectWidget::widget(['tpl' => 'project', 'id' => $project->id]) ?>
        </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

