<?php

use app\components\TimeSupport;
use yii\helpers\Url;
use yii\bootstrap\Html;
use app\modules\user\models\User;

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

            <div class="col-xs-1 pl-1 pt-2">
                <?= Html::input('checkbox', 'test', '123', [
                    'id' => $idtoggle,
                    'data-toggle' => 'toggle',
                    'data-on' => '<i class="glyphicon glyphicon-ok"> </i>',
                    'data-off' => '<i class="glyphicon glyphicon-remove"> </i>',
                    'data-size' => 'sm',
                    'data-offstyle' => $color_toggle[$task['id']],
                    'data-onstyle' => 'warning',
                ]) ?>
            </div>
            <div class="col-xs-8 ">
                <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>"
                   title="<?= $task['description'] ?>" id="<?= $tool_id ?>" class="text-body">
                    <?= $task['title'] ?>
                </a>
                <br>
                <?php if ($task['updated_at'] != null): ?>
                    <?= TimeSupport::createtime($task['updated_at']) ?>
                <? endif; ?>
            </div>
            <div class="col-xs-3 text-right">
                <!-- Single button -->
                <?php if ((!empty($users)) || (!empty($project))): ?>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <?php if (($task['user_id'] == null) && (Yii::$app->user->id == $project['creator_id'])): ?>
                                <li role="presentation" class="dropdown-header">Поручить пользователю</li>
                                <?php foreach ($users as $user): ?>
                                    <li><?= Html::a($user['username'], ['/task/user/set-executor', 'user_id' => $user->id, 'project_id' => $project['id'],  'task_id' => $task['id']]); ?></li>
                                <?php endforeach; ?>
                            <?php elseif ($task['user_id'] == Yii::$app->user->id): ?>
                                <li role="presentation" class="dropdown-header">Задача была закреплена за вами</li>
                                <?php if (Yii::$app->user->id == $project['creator_id']): ?>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation" class="dropdown-header">Закрепить за новым пользователем
                                    </li>
                                    <?php foreach ($users as $user): ?>
                                        <li><?= Html::a($user['username'], ['/task/user/set-executor', 'user_id' => $user->id, 'project_id' => $project['id'],  'task_id' => $task['id']]); ?></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php elseif ($task['user_id'] != null): ?>
                                <li role="presentation" class="dropdown-header">Задача поручена пользователю</li>
                                <strong>
                                    <li role="presentation"
                                        class="dropdown-header text-center"><?= User::findOne($task['user_id'])->username ?></li>
                                </strong>
                                <?php if (Yii::$app->user->id == $project['creator_id']): ?>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation" class="dropdown-header">Закрепить за новым пользователем
                                    </li>
                                    <?php foreach ($users as $user): ?>
                                        <li><?= Html::a($user['username'], ['/task/user/set-executor', 'user_id' => $user->id, 'project_id' => $project['id'],  'task_id' => $task['id']]); ?></li>
                                    <?php endforeach; ?>
                                    <li role="presentation" class="divider"></li>
                                    <li><?= Html::a('Открепить', ['/task/user/del-executor', 'task_id' => $task['id'], 'project_id' => $project['id']]); ?></li>
                                <?php endif; ?>
                            <?php else: ?>
                                <li role="presentation" class="dropdown-header">Задача общая</li>
                                <?php if (Yii::$app->user->id == $project['creator_id']): ?>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation" class="dropdown-header">Закрепить за новым пользователем
                                    </li>
                                    <?php foreach ($users as $user): ?>
                                        <li><?= Html::a($user['username'], ['/task/user/set-executor', 'user_id' => $user->id, 'project_id' => $project['id'],  'task_id' => $task['id']]); ?></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>

                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-cog"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li role="presentation" class="dropdown-header">Настройки</li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (($status == 1) || ($status == 2)) {
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

