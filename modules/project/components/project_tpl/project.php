<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\project\components\TimeColorSignWidget;

?>
<div class="col-sm-<?= $csscol ?> ">
    <div class="bg-light pb-2 border rounded-bottom shadow-sm rounded-lg mt-3">
        <div class="p-3 mb-2 bg-info text-white text-center">
            <a href="<?= Url::to(['view', 'id' => $project['id']]) ?>"
               class="text-body pl-3"> <?= $project['title'] ?></a>
        </div>
        </a>
        <hr>

        <div class="text-center">
            <?php foreach ($tasks as $task): ?>
                <?php if (($task['project_id'] == $project['id']) && ($task['status'] != 0)): ?>

                    <?= Html::a($task['title'],['/task/user/update', 'id' => $task['id']],['class' => 'text-body pl-3'])?>
                    <?= Html::a('(выполнено) ', Url::to(['/task/user/complete', 'id' => $task['id'], 'redirect' => '/project/default']), ['class' => ' text-secondary']) ?>
                    <?= TimeColorSignWidget::widget(['seconds' => $task['updated_at']]); ?>

                    <br>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (isset($project['projects'])): ?>
                <hr>
                <?php foreach ($project['projects'] as $child): ?>
                    <dl>
                        <dt>


                            <a href="<?= Url::to(['view', 'id' => $child['id']]) ?>"
                               class="text-body pl-3 "> <?= $child['title'] ?>:</a>
                            <br></dt>


                        <?php foreach ($tasks as $task): ?>
                            <dd>
                            <?php if (($task['project_id'] == $child['id'])): ?>

                                <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>"
                                   class="text-body pl-3"> <?= $task['title'] ?> </a>
                                <?= Html::a('(выполнено) ', Url::to(['/task/user/complete', 'id' => $task['id'], 'redirect' => '/project/default']), ['class' => ' text-secondary']) ?>
                                <?= TimeColorSignWidget::widget(['seconds' => $task['updated_at']]); ?>

                                </dd>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </dl>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>
