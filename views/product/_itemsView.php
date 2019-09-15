<?php
use yii\helpers\Url;

?>
<div class="products_item col-md-4 col-sm-6 col-xs-12">
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
                    <p class="group inner list-group-item-text"><?=$model->description_min?></p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p class="lead"><?=$model->price?> руб.</p>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <a class="btn btn-success" href="<?=$model->viewUrl();?>">Купить</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>