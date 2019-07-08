<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\project\components\TimeColorSignWidget;

?>
<div class="col-sm-<?= $csscol ?> ">
    <a href="">
        <div class="bg-light pb-2 border rounded-bottom shadow-sm rounded-lg">
            <div class="p-3 mb-2 bg-info text-white text-center">
                <a href="<?= Url::to(['view', 'id' => $project['id']]) ?>"
                   class="text-body pl-3"> <?= $project['title'] ?></a>
            </div>
    </a>
    <hr>
    <?php if (isset($project['projects'])): ?>
        <?php foreach ($project['projects'] as $child): ?>


        <?php endforeach; ?>
    <?php endif; ?>

    <div class="text-center">
        <?php foreach ($tasks as $task): ?>
            <?php if (($task['project_id'] == $project['id'])): ?>

                    <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>"
                       class="text-body pl-3"> <?= $task['title'] ?> </a>
                    <?php echo Html::a('(выполнено) ', Url::to(['/task/user/complete', 'id' => $task['id'], 'redirect' => '/project/default']), ['class' => ' text-secondary']) ?>
                    <?= TimeColorSignWidget::widget(['seconds' => $task['updated_at']]); ?>

                <br>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if (isset($project['projects'])): ?>
            <?php foreach ($project['projects'] as $child): ?>
                <hr>
                <b>
                    <a href="<?= Url::to(['view', 'id' => $child['id']]) ?>"
                       class="text-body pl-3 "> <?= $child['title'] ?>:</a>
                </b><br>


                <?php foreach ($tasks as $task): ?>
                    <?php if (($task['project_id'] == $child['id'])): ?>

                            <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>"
                               class="text-body pl-3"> <?= $task['title'] ?> </a>
                            <?php echo Html::a('(выполнено) ', Url::to(['/task/user/complete', 'id' => $task['id'], 'redirect' => '/project/default']), ['class' => ' text-secondary']) ?>
                            <?= TimeColorSignWidget::widget(['seconds' => $task['updated_at']]); ?>

                        <br>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>
</div>

