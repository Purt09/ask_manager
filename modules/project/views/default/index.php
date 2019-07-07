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
                <?= Html::button(Module::t('module', 'PROJECT_CREATE'), ['data-toggle' => 'modal', 'data-target' => '#CreateProject', 'class' => 'btn-success btn']) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">

                <?= Html::a(Module::t('module', 'PROJECT_COMPLETE'), Url::to('default/create'), ['class' => 'btn btn-warning']) ?>
            </div>
        </div>
    </div>
    <br><br>
    <hr/>
    <div class="row">
        <?= \app\modules\project\components\ProjectWidget::widget(['projects' => $projects]) ?>
    </div>
</div>

<?= CreateProjectWidget::widget([]) ?>
