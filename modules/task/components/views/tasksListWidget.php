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
            $script = <<< JS
                $(function() {
                        $('#$idtoggle').change(function() {
                            setTimeout(function(){ $('$id_del_class').remove();}, 500);
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
        <?php if(($status == 1) || ($status == 2)) {
            $js = <<<JS
 $("#$idtoggle").change(function() {
 var data = $(this).serialize();
 $.ajax({
 url: '/task/user/complete',
 type: 'GET',
 data: "id=$id",
 success: function(res){
 console.log(res);
 },
 error: function(){
 alert('Error!');
 }
 });
 return false;
 });
JS;
        } else {
            $js = <<<JS
 $("#$idtoggle").change(function() {
 var data = $(this).serialize();
 $.ajax({
 url: '/task/user/uncomplete',
 type: 'GET',
 data: "id=$id",
 success: function(res){
 console.log(res);
 },
 error: function(){
 alert('Error!');
 }
 });
 return false;
 });
JS;
        }
        $this->registerJs($js, \yii\web\View::POS_END);
        ?>
    <? endif; ?>
<?php endforeach; ?>

