<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\task\components\TimeColorSignWidget;

?>
<div class="text-center">
    <?php foreach($project as $task):  ?>
        <b>
            <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>" class="text-body pl-3"> <?= $task['title'] ?> </a>

            <?php echo Html::a('(выполнено) ', Url::to(['/task/user/complete', 'id' => $task['id'], 'redirect' => '/project/default']), ['class'=>' text-secondary'])?>

            <?= TimeColorSignWidget::widget(['seconds' => $task['updated_at']]); ?>

        </b>

        <br>
    <?php endforeach; ?>


