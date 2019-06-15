<?php

use yii\helpers\Html;
use app\modules\task\components\CreateTaskWidjet;
use yii\helpers\Url;
use app\modules\task\Module;



/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'PROJECTS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <br>
    <div class="container">
        <div class="col-sm-8">
            <h2><?php echo $model->title ?> </h2>
            <div class="mod-row">
                <div class="col-sm-6 mr-3 border rounded-bottom shadow-sm rounded-lg">
                    <div class="row">
                        <div class="p-3  bg-info text-white" >
                            Задачи:
                        </div>
                        <div class="p-3 bg-light rounded-bottom" >
                            <?php foreach ($tasksactive as $task): ?>
                                <?= $task['id'] ?>
                                <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>" class="text-body pl-3"> <?= $task['title'] ?> </a>
                            <?php $link = '/project/' . $model->id ?>
                                <?= Html::a('(выполнено)', Url::to(['/task/user/complete', 'id' => $task['id'], 'redirect' => $link]), ['class'=>' text-secondary']) ?>
                                <br>

                            <?php endforeach; ?>
                            <?php $datatarget = '#CreateTask' . $model->id; ?>
                            <?= Html::button(Module::t('module', 'TASK_CREATE'), ['data-toggle' => 'modal', 'data-target' => $datatarget, 'class' => 'btn-success btn']) ?>
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
                            <?= Html::a('(выполнено)', Url::to(['/task/user/complete', 'id' => $task['id'], 'redirect' => '/project/default/view']), ['class'=>' text-secondary']) ?>

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
                    <?php endforeach; ?>
                </div>
            </div>
        </div>



    </div>
</div>
<?= CreateTaskWidjet::widget([
        'project_id' => $model->id,
]) ?>
