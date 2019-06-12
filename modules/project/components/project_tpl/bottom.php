<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\task\Module;
use app\modules\task\components\CreateTaskWidjet;

?>
<hr>
<p>
    <?= Html::button(Module::t('module', 'TASK_CREATE'), ['data-toggle' => 'modal', 'data-target' => '#CreateTask', 'class' => 'btn-success btn']) ?>
</p>

</div>
</div>

<?= CreateTaskWidjet::widget([
        'project_id' => $project['id'],
]) ?>