<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\project\components\TimeColorSignWidget;


?>
<div class="col-sm-<?= $csscol ?>">
    <div class="panel panel-primary ">
        <div class="panel-heading text-center ">
            <a href="<?= Url::to(['view', 'id' => $project['id']]) ?>"
               class="text-white pl-3 col-xs-11"> <?= $project['title'] ?></a>
            <?= Html::a('<span class="glyphicon glyphicon-remove text-warning"></span>', ['/project/default/delete', 'id' => $project['id']], ['class' => 'col-1']) ?>

            </a>


        </div>

        <div class="panel-body">
            <?php foreach ($tasks as $task): ?>
                <?php if (($task['project_id'] == $project['id']) && ($task['status'] != 0)): ?>


                    <?= Html::a($task['title'], ['/task/user/update', 'id' => $task['id']], ['class' => 'text-body pl-3']) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-ok"></span>', ['/task/user/complete', 'id' => $task['id']], ['class' => 'pl-3']) ?>
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
                            <?php if (($task['project_id'] == $child['id']) && ($task['status'] != 0)): ?>

                                <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>"
                                   class="text-body pl-3"> <?= $task['title'] ?> </a>
                                <?= Html::a('<span class="glyphicon glyphicon-ok"></span>', ['/task/user/complete', 'id' => $task['id']], ['class' => 'pl-3']) ?>
                                <?= TimeColorSignWidget::widget(['seconds' => $task['updated_at']]); ?>

                                </dd>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </dl>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="panel-footer"><?= $project['time_at'] ?></div>
    </div>
</div>
