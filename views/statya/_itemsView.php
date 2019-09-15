<?php
use yii\helpers\Url;
?>
<div class="statyas_item col-md-6 col-sm-12 col-xs-12">
    <div class="thumbnail">
        <div class="row">
            <div class="col-sm-12">
                <?
                //            foreach($model->getBehavior('galleryBehavior')->getImages() as $image) {
                //                echo Html::img($image->getUrl('medium'));
                //            }
                $img = $model->getBehavior('galleryBehavior')->getImages()[0];
                if(!empty($img)){
                    ?>
                    <div class="group list-group-image"
                         style="height: 200px;background-size: cover;background-image: url('<?=$img->getUrl('medium') ;?>') "
                         alt="<?=$img->name ;?>"
                         title="<?=$img->description ;?>"
                        ></div>
                <? } else {?>
                    <div class="group list-group-image"
                         style="height: 200px;background-color:#eee;"
                         title=""
                        ></div>
                <? }?>
            </div>
            <div class="col-sm-12">
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
                        <a href="<?=$model->viewUrl();?>"><?=$model->name?></a>
                    </h4>
                    <p class="group inner list-group-item-text"><?=$model->description_min?>
                    <p class="group inner list-group-item-text">
                     <a href="<?=$model->viewUrl()?>">Подробней</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>