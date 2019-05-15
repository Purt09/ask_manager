<?php
/* @var $this yii\web\View */
use app\modules\project\Module;
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\Vardump;
?>

<div class="container">
    <div class="text-center" >
        <div class="col-sm-6">
            <div class="row">
                123
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                456
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <?php foreach ($projects as $project) : ?>
        <div class="col-sm-4 text-center">



            <div class="bg-light">
                <div class="p-3 mb-2 bg-info text-white" >
                    <?=  $project->title; ?>
                </div>
                <b>
                    <?php for($i=0; $i<count($task[$project->id]);$i++):  ?>
                        <br>
                        <a href="<?= Url::to(['/task/user/update', 'id' => $task[$project->id][$i]->id]) ?>" class="text-body pl-3"> <?= $task[$project->id][$i]->title ?> </a>
                    <?php endfor; ?>
                </b>
            </div>

        </div>


            <?php endforeach; ?>
        </div>
    </div>
</div>
