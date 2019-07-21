<?php

use app\components\TimeSupport;
use yii\helpers\Url;
use yii\bootstrap\Html;

?>

<?php foreach ($tasks as $task) : ?>
    <?php if ($task['status'] == $status): ?>
        <div class="bg-light  p-1 pb-0 shadow-sm mb-4 row del<?= $task['id'] ?>">
            <?php
            $id = $task['id'];
            $idtoggle = 'toggle-event-' . $task['id'];
            $id_del_class = 'div.del' . $task['id'];
            $tool_id = 'tooltip-' . $task['id'];
            $url = Url::to(['/task/user/' . $complete, 'id' => $task['id'], 'redirect' => $redirect]);
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
            <div class="col-xs-1 pl-1 mr-3 pt-2">
                <?= Html::input('checkbox', 'test', '123', [
                    'id' => $idtoggle,
                    'data-toggle' => 'toggle',
                    'data-on' => '<i class="glyphicon glyphicon-ok"> </i>',
                    'data-off' => '<i class="glyphicon glyphicon-remove"> </i>',
                    'data-size' => 'sm',
                    'data-offstyle' => 'success',
                    'data-onstyle' => 'warning',
                ]) ?>
            </div>
            <div class="col-xs-10 ">
                <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>"
                   title="<?= $task['description'] ?>" id="<?= $tool_id ?>" class="text-body">
                    <?= $task['title'] ?>
                </a>
                <br>
                <?php if ($task['updated_at'] != null): ?>
                    <?= TimeSupport::createtime($task['updated_at']) ?>
                <? endif; ?>
            </div>
            <div class="col-xs-1 ">
            </div>
        </div>
    <? endif; ?>
<?php endforeach; ?>