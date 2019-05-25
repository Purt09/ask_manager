<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="text-center">
    <?php foreach($project as $task):  ?>
        <b>
            <a href="<?= Url::to(['/task/user/update', 'id' => $task['id']]) ?>" class="text-body pl-3"> <?= $task['title'] ?> </a>
            <? echo Html::a('(выполнено)', Url::to(['/task/user/complete', 'id' => $task['id']]), ['class'=>' text-secondary']) ?>
        </b>

        <br>
    <?php endforeach; ?>