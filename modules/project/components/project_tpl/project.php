<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\project\components\TimeColorSignWidget;

?>

    <a href="">
        <div class="bg-light pb-2 border rounded-bottom shadow-sm rounded-lg">
            <div class="p-3 mb-2 bg-info text-white text-center" >
                <a href="<?= Url::to(['view', 'id' => $project['id']]) ?>" class="text-body pl-3"> <?=   $project['title'] ?></a>
            </div>

    </a>
    <hr>
    <?php if(isset($project['childs'])): ?>
        <?php foreach($project['childs'] as $child): ?>
            <b>
                <a href="<?= Url::to(['view', 'id' => $child['id']]) ?>" class="text-body pl-3"> <?=   $child['title'] ?></a>
            </b>
            <hr>

        <?php endforeach;?>
    <?php endif;?>

<div class="text-center">
    <?php foreach($tasks as $task):  ?>
        <b>
            <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>" class="text-body pl-3"> <?= $task['title'] ?> </a>

            <?php echo Html::a('(выполнено) ', Url::to(['/task/user/complete', 'id' => $task['id'], 'redirect' => '/project/default']), ['class'=>' text-secondary'])?>

            <?= TimeColorSignWidget::widget(['seconds' => $task['updated_at']]); ?>

        </b>

        <br>
    <?php endforeach; ?>
    <hr>
    <p>
        <?= Html::a('Добавить задачу', Url::to(['/task/user/create', 'project_id' => $project['id']]), ['class'=>'btn btn-success']) ?>
    </p>

</div>
</div>

