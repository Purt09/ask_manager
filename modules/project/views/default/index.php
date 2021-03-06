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
    <div class="text-center">
        <div class="col-sm-6">
            <div class="row">
                <?= CreateProjectWidget::widget(['projects' => $projects]) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
            </div>
        </div>
    </div>
    <br><br>
    <hr/>
    <div class="row">
        <?= \app\modules\project\components\ProjectWidget::widget([
                'projects' => $projects,
                'tasks' => $tasks,
            ]) ?>
    </div>
</div>


