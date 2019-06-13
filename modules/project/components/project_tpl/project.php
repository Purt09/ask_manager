<?php
use yii\helpers\Url;

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



