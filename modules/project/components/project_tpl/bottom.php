<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<hr>
<p>
    <?= Html::a('Добавить задачу', Url::to(['/task/user/create', 'project_id' => $project['id']]), ['class'=>'btn btn-success']) ?>
</p>

</div>
</div>