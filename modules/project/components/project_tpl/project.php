<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="col-sm-4 ">
    <a href="">
        <div class="bg-light pb-2">
            <div class="p-3 mb-2 bg-info text-white text-center" >
                <?= $project['title'] ?>
                <?php if(isset($project['childs'])): ?>
                    +
                <?php endif;?>
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



