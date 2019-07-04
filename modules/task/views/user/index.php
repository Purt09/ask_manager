<?php

use yii\helpers\Html;
use app\modules\task\Module;
use yii\helpers\Url;
use app\components\TimeSupport;
use app\modules\task\components\CreateTaskWidjet;

/* @var $modelsactive app\modules\task\models\Task */
$time = time();

$this->title = Module::t('module', 'TASKS');
$this->params['breadcrumbs'][] = $this->title;


?>


    <div class="container">
        <div class="text-center">
            <div class="col-sm-7">
                <div class="row p-3">
                    <?= Html::button(Module::t('module', 'TASK_CREATE'), ['data-toggle' => 'modal', 'data-target' => '#CreateTask', 'class' => 'btn-success btn']) ?>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="row p-3">
                    <?= Html::a(Module::t('module', 'TASK_COMPLETE'), ['user/done'], ['class' => 'btn btn-warning']) ?>
                </div>
            </div>

        </div>

        <hr/>
        <div class="row">
            <div class="col-sm-8">
                <div class="p-3 mb-2 bg-info text-white row mr-1 shadow ">
                    <?= Module::t('module', 'TASK_ACTIVE') ?>:
                </div>
                <?php foreach ($models as $model) : ?>
                    <?php if ($model['status'] == 1): ?>
                        <div class="bg-light  p-1 shadow-sm row mr-1 del<?= $model['id'] ?>">
                            <?php
                            $id = $model['id'];
                            $idtoggle = 'toggle-event-' . $model['id'];
                            $id_del_class = 'div.del' . $model['id'];
                            $tool_id = 'tooltip-' . $model['id'];
                            $url = Url::to(['complete', 'id' => $model['id']]);
                            $url = '"http://' . $_SERVER['SERVER_NAME'] . $url . '"';

                            $script = <<< JS
$(function() {
        $('#$idtoggle').change(function() {
            $('$id_del_class').remove();
            document.location.href = $url;
        })
    })
   $('#$tool_id').tooltip();
JS;

                            $this->registerJs($script, yii\web\View::POS_READY);
                            ?>
                            <div class="col-xs-1">
                                <?= '<input id="' . $idtoggle . '" type="checkbox" checked data-toggle="toggle" data-on="<i class=\'glyphicon glyphicon-remove\'> </i>" data-off="<i class=\'glyphicon glyphicon-ok\'> </i>" data-size="sm" data-onstyle="success">';
                                ?>
                            </div>
                            <div class="col-xs-7 ml-3">
                                <a href="<?= Url::to(['update', 'id' => $model['id']]) ?>"
                                   title="<?= $model['description'] ?>" id="<?= $tool_id ?>" class="text-body pl-3">
                                    <?= $model['title'] ?> </a>
                            </div>
                            <div class="pull-right col-4">
                                <?php if ($model['updated_at'] != null): ?>
                                    <?= TimeSupport::createtime($model['updated_at'] - $time) ?>
                                <? endif; ?>
                            </div>
                        </div>
                        <br>
                    <? endif; ?>
                <?php endforeach; ?>
            </div>
            <br>

            <div class="col-sm-4">
                <div class="p-3 mb-2 bg-danger text-white row shadow ">
                    <?= Module::t('module', 'TASK_OVERDUE') ?>:
                </div>
                <?php foreach ($models as $model) : ?>
                    <?php if ($model['status'] == 2): ?>
                        <div class="bg-light shadow-sm p-1 row ">
                            <?php
                            $id = 'toggle-event-' . $model['id'];
                            $tool_id = 'tooltip-' . $model['id'];
                            $url = Url::to(['complete', 'id' => $model['id']]);
                            $url = '"http://' . $_SERVER['SERVER_NAME'] . $url . '"';

                            $script = <<< JS
$(function() {
        $('#$id').change(function() {
            document.location.href = $url;
        })
        $('#$tool_id').tooltip();
    })
JS;
                            $this->registerJs($script, yii\web\View::POS_READY);
                            ?>
                            <div class="col-xs-1">
                                <?= '<input id="' . $id . '" type="checkbox" checked data-toggle="toggle" data-on="<i class=\'glyphicon glyphicon-remove\'> </i>" data-off="<i class=\'glyphicon glyphicon-ok\'> </i>" data-size="sm" data-onstyle="success">';
                                ?>
                            </div>
                            <div class="col-xs-10 ml-3">
                                <a href="<?= Url::to(['update', 'id' => $model['id']]) ?>"
                                   title="<?= $model['description'] ?>" id="<?= $tool_id ?>" class="text-body pl-3">
                                    <?= $model['title'] ?> </a>
                            </div>
                        </div>
                        <br>
                    <? endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?= CreateTaskWidjet::widget([]) ?>