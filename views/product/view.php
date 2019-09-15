<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dvizh\cart\widgets\BuyButton;
use app\models\StatyaGroup;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo newerton\fancybox\FancyBox::widget([
    'target' => 'a[rel=fancybox]',
    'helpers' => true,
    'mouse' => true,
    'config' => [
        'maxWidth' => '90%',
        'maxHeight' => '90%',
        'playSpeed' => 7000,
        'padding' => 0,
        'fitToView' => false,
        'width' => '70%',
        'height' => '70%',
        'autoSize' => false,
        'closeClick' => false,
        'openEffect' => 'elastic',
        'closeEffect' => 'elastic',
        'prevEffect' => 'elastic',
        'nextEffect' => 'elastic',
        'closeBtn' => false,
        'openOpacity' => true,
        'helpers' => [
            'title' => ['type' => 'float'],
            'buttons' => [],
            'thumbs' => ['width' => 68, 'height' => 50],
            'overlay' => [
                'css' => [
                    'background' => 'rgba(0, 0, 0, 0.8)'
                ]
            ]
        ],
    ]
]);

?>

<div class="product-view">
    <div class="row">
        <div class="col-sm-8 col-sm-push-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <?/*= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'price',
                'name',
                'url:url',
                'characteristics:ntext',
                'description_min:ntext',
                'description:ntext',
                'foto',
                'meta_keywords',
                'meta_description',
                'status',
                'created_at',
                'updated_at',
            ],
        ]) */?>
        <div class="products_item">
            <div class="row">

                <div class="col-xs-12 col-md-12 col-sm-12">
                    <div class="thumbnail photo-big">
                        <?
                        $imgs = @$model->getBehavior('galleryBehavior')->getImages();
                        if(!empty($imgs[0])){
                            ?>
                            <a class="group photo-big"
                                href="<?=$imgs[0]->getUrl('original')?>" 
                              
                                 style="background-image: url('<?=$imgs[0]->getUrl('original') ;?>') "
                                 alt="<?=$imgs[0]->name ;?>"
                                 title="<?=$imgs[0]->description ;?>"
                                ></a>
                        <? } else {?>
                            <div class="group list-group-image"
                                 style="height: 200px;background-color:#eee;"
                                 title=""
                                ></div>
                        <? }?>
                    </div>
                    <div class="list_thumbnail">
                        <div class="row">
                        <?
                            if (count($imgs) > 1) {

                                foreach($imgs as $key => $img)
                                {
                                    ?>
                                    <div class="col-md-1 col-sm-2 col-xs-3">
                                        <a class="group photo-min"
                                            href="<?=$img->getUrl('original')?>" 
                                             rel="fancybox" 
                                             style="background-image: url('<?=$img->getUrl('small') ;?>') "
                                             alt="<?=$img->name ;?>"
                                             title="<?=$img->description ;?>"
                                            ></a>
                                    </div>
                                    <?
                                }
                            }
                        ?>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <div class="price"><?=$model->price?> руб.</div>
                        <form class="add_product_in_cart" method="post" action="/order/add-to-cart/">
                            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                            <input type="hidden" name="product_id" value="<?=$model->id?>">
                            <input class="form-control" style="display: inline-block; width: 60px;"
                                   type="number" step="1" min="1" name="count" value="1"
                                   title="Колличество" size="4"
                            >
                           <button class="btn btn-success btn-shopping-cart" onclick="$('.add_product_in_cart').submit(); yaCounter45810204.reachGoal('KUPIT');" ><i class="fa fa-shopping-cart"></i> Купить</button>

                            
                        </form>
                         <!--<a href="<?=$_SERVER['REQUEST_URI']?>">
                            <button class="btn btn-success btn-shopping-cart"  onclick="$('.add_product_in_cart').submit();" ><i class="fa fa-shopping-cart"></i> Купить</button>
                            </a>-->
                        <?/* if (0) { ?>
                        <input class="form-control" style="display: inline-block; width: 60px;"
                               type="number" step="1" min="1" name="count" value="1"
                               title="Колличество" size="4"
                               onchange="$(this).next().attr('data-count',$(this).val())"
                        >
                        <?= BuyButton::widget([
                            'model' => $model,
                            'text' => '<i class="fa fa-shopping-cart"></i> Купить',
                            'htmlTag' => 'a',
                            'cssClass' => 'btn btn-success btn-shopping-cart'
                            ]) 
                        ?>
                        <? } */?>
                    </div>
                    <div class="form-group">
                        <h3>Характеристики</h3>
                        <div class="characteristics"><?=$model->characteristics?></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-12">
                    <h3>Описание</h3>
                    <div class="description"><?=$model->description?></div>
                </div>

            </div>
        </div>

        </div>
        <div class="col-sm-4 col-sm-pull-8 statyas_menu">
        <div id="w1" class="row statyas_items">
                <div class="col-md-12"><h3 class="carousel-title"></h3></div>
                <div class="clearfix"></div>



                <div class="clearfix">
                    <section class="ac-container">

                        <?
                        $list_groups = StatyaGroup::find()->orderBy(['sort_main'=>SORT_ASC])->all();
                        if (!empty($list_groups)) {
                            foreach ($list_groups as $key => $group) { ?>
                        <div class="statyas_item col-sm-12 col-xs-12">
                            <input id="ac-<?=$group['id']?>" name="accordion-<?=$group['id']?>" type="checkbox"/>
                            <label for="ac-<?=$group['id']?>"><?=$group['name']?></label>
                            <article>
                                    <?
                                        echo app\widgets\statya\WidgetStatyaItems::widget(['optionNew'=>[
                                                'search' => false,
                                                'pjaxEnable' => false,
                                                'titleOff' => true,
                                                'pageSize' =>'1000',
                                                'breadcrumbs' =>false,
                                                'isPage' =>false,
                                                'andWhere' => [ 'status' => 1, 'group_id' => $group['id']],
                                                'andWhereAll' => true,
                                            ]]);
                                            ?>
                            </article>
                        </div>
                            <?
                            }
                        }
                            ?>
                    </section>
                </div>

            </div>
        </div>
    </div>

</div>
