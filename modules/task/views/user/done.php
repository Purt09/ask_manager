<?php
use app\modules\task\Module;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Выполненные задачи";
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'TASKS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    <div class="text-center pb-5" >
        <div class="col-sm-6">
            <div class="row">
                <?= Html::a(Module::t('module', 'TASK_CREATE'), ['user/create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <?= Html::a(Module::t('module', 'TASKS'), ['user/index'], ['class' => 'btn btn-info']) ?>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-sm">
            <div class="p-3 mb-2 bg-warning shadow  text-black row mb-5" >
                <?= Module::t('module', 'TASK_COMPLETE') ?> :
            </div>
            <?php foreach ($models as $model) : ?>
                <div class="bg-light shadow-sm p-1 row">
                    <?php
                    $id = 'toggle-event-' . $model['id'];
                    $tool_id = 'tooltip-' . $model['id'];
                    $url = Url::to(['uncomplete', 'id' => $model['id']]);
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
                        <?= '<input id="' . $id . '" type="checkbox" checked data-toggle="toggle" data-on="<i class=\'glyphicon glyphicon-ok\'> </i>" data-off="<i class=\'glyphicon glyphicon-remove\'> </i>" data-size="sm" data-onstyle="success">';
                        ?>
                    </div>
                    <div class="col-xs-10 ml-3">
                        <a href="<?= Url::to(['update', 'id' => $model['id']]) ?>" title="<?= $model['description'] ?>" id="<?= $tool_id ?>" class="text-body pl-3">
                            <?= $model['title'] ?> </a>
                    </div>
                </div>
                <br>
            <?php endforeach; ?>
        </div>
    </div>
</div>
