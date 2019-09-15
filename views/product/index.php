<?php
use app\models\Product;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\StatyaGroup;
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::t('app', 'Products').' '.yii::$app->params['mainTitle']]);
$this->registerMetaTag(['name' => 'description', 'content'  => Yii::t('app', 'Products').' '.yii::$app->params['mainTitle']]);


// echo app\widgets\product\WidgetProductItems::widget([
//         'optionNew' => [
//             'pageSize' => 0,
//         ]
//     ]);

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-sm-8 col-sm-push-4 product_menu product_all">
        <h1 class="title-page"><?= Html::encode($this->title) ?></h1>
        <?
        $products = Product::find()->all();
        if (!empty($products)) {
            foreach ($products as $key => $product) { 
        ?>
        <div class="thumbnail">
            <div class="row">
                <div class="col-sm-12">
                    <?
                    //            foreach($model->getBehavior('galleryBehavior')->getImages() as $image) {
                    //                echo Html::img($image->getUrl('medium'));
                    //            }
                    $img = $product->getBehavior('galleryBehavior')->getImages()[0];
                    if(!empty($img)){
                        ?>
                        <a  href="<?=$product->viewUrl();?>">
                        <div class="group list-group-image"
                             style="background-image: url('<?=$img->getUrl('medium') ;?>') "
                             alt="<?=$img->name ;?>"
                             title="<?=$img->description ;?>"
                            ></div>
                            </a>
                    <? } else {?>
                        <div class="group list-group-image"
                             style="height: 200px;background-color:#eee;"
                             title=""
                            ></div>
                    <? }?>
                </div>
                <div class="col-sm-12">
                    <div class="caption">
                        <h4 class="form-group name">
                            <a  href="<?=$product->viewUrl();?>"><?=$product->name?></a>
                        </h4>
                        <div class="form-group description_min"><?=$product->description_min?></div>
                        <div class="row text-center">
                            <div class="price1"><?=$product->price?> руб.</div>
                            <a class="btn btn-success btn-shopping-cart" href="<?=$product->viewUrl();?>"><i class="fa fa-shopping-cart"></i> Купить</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?
            }
        }
    ?>

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