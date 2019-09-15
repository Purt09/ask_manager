<?php
use app\models\Video;
use app\widgets\VideoEmbed;
use app\models\Product;
use app\models\StatyaGroup;
use app\models\Statya;
use yii\helpers\Url;
/* @var $this yii\web\View */
?>  
<div class="site-index">
    <div class="row">
        <div class="col-sm-3 statyas_menu">
            <div id="w1" class="row statyas_items">
                <div class="col-md-12"><h3 class="carousel-title"></h3></div>
                <div class="clearfix"></div>



                <div class="clearfix">
                    <section class="ac-container">

                        <?
                        $list_groups = StatyaGroup::find()->orderBy(['sort_main'=>SORT_ASC])->all();
                        $num = 0;
                        if (!empty($list_groups)) {
                            foreach ($list_groups as $key => $group) { 
                                if ($group['id'] == 7) {
                                    $news_group = $group;
                                } else {
                                    $checked = '';
                                    if ($num == 0) {
                                        //$checked = 'checked';
                                    }
                                    $num++;
                                    ?>
                                    <div class="statyas_item col-sm-12 col-xs-12">
                                        <input id="ac-<?=$group['id']?>" name="accordion" type="radio" <?=$checked?>/>
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
                        }

                        ?>
                            <div class="statyas_item col-sm-12 col-xs-12">
                                <input id="ac-<?=$news_group['id']?>" name="accordion-<?=$news_group['id']?>" type="radio" checked />
                                <label for="ac-<?=$news_group['id']?>"><?=$news_group['name']?></label>
                                <article>
                                        <?
                                            echo app\widgets\statya\WidgetStatyaItems::widget(['optionNew'=>[
                                                    'search' => false,
                                                    'pjaxEnable' => false,
                                                    'titleOff' => true,
                                                    'pageSize' =>'1000',
                                                    'breadcrumbs' =>false,
                                                    'isPage' =>false,
                                                    'andWhere' => [ 'status' => 1, 'group_id' => $news_group['id']],
                                                    'andWhereAll' => true,
                                                ]]);
                                                ?>
                                </article>
                            </div>
                        <?
                            ?>
                    </section>
                </div>

            </div>

        
        </div>
            <h1 style="display:none">Катушки Мишина. Вихревая медицина на сайте mihailosipov.ru</h1>

        <div class="col-sm-6 product_menu">

            <?php
            $statya = Statya::findOne('53');
/*echo "<pre>"; 
print_r($statya); 
echo "</pre>";*/
            ?>

            <div class="col-sm-12 thumbnail">
                <div class="col-sm-12">
                    <h3><?=$statya->name?></h3>
                    <div id="hide-id-2" class="description-article">
                        <p><?php
                        echo mb_substr($statya->description, 0, 195)."...";
                        ?></p>
                    </div>
                    <div id="hide-id-1" class="collapse more">
                        <p><?=$statya->description?></p>
                    </div>
                    <a data-toggle="collapse" onclick="if($('#hide-id-2').css('display') == 'none'){ $('#hide-id-2').css('display', 'block');} else {$('#hide-id-2').css('display', 'none');}" data-parent="#collapse-group" href="#hide-id-1">Читать далее...</a>
                </div>
            </div>


            <?
            $products = Product::find()->orderBy(['sort_main'=>SORT_ASC])->all();
            if (!empty($products)) {
                foreach ($products as $key => $product) { 
            ?>
            <div class="thumbnail col-sm-4">
                <div class="row">
                    <div class="col-sm-12">
                        <?
                        //            foreach($model->getBehavior('galleryBehavior')->getImages() as $image) {
                        //                echo Html::img($image->getUrl('medium'));
                        //            }
                        $img = $product->getBehavior('galleryBehavior')->getImages()[0];
                        if(!empty($img)){
                            ?>
                            <a href="<?=$product->viewUrl();?>">
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
                                <a href="<?=$product->viewUrl();?>"><?=$product->name?></a>
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
        <div class="col-sm-3 video_menu">
            <?
            $videos = Video::find()->where(['status' => 1, 'view_main' => 1])->limit(3)->orderBy(['sort_main'=>SORT_ASC])->all();
            if (!empty($videos)) {
                foreach ($videos as $key => $video) {
                    // $info = \Embed\Embed::create($video->url);
                    // echo $info->code;
                    echo VideoEmbed::widget(['url' => $video->url]);
                    // echo '<pre>';
                    // var_dump($video->url);
                    // echo '</pre>';
                }
            }
            ?>
            <p class="text-center">
            <a class="" href="/video/index">Показать все видео</a>
            </p>

            <div id="vk_widget" style="width: 100%;">
                <div id="vk_groups" style="width: 100%;"></div>
            </div>
			
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>
            <script>
                function VK_Widget_Init(){
                    document.getElementById('vk_groups').innerHTML = "";
                    var vk_width = document.getElementById('vk_widget').clientWidth;
                    VK.Widgets.Group("vk_groups", { width: vk_width, mode: 3, no_cover: 1, color3: "0088B5"}, 136445645);
                };
                window.addEventListener('load', VK_Widget_Init, false);
                window.addEventListener('resize', VK_Widget_Init, false);
            </script>

     
        </div>
    </div>
    <?/*if (0) { ?>
    <div class="WidgetProductItems">
    <?
    echo app\widgets\product\WidgetProductItems::widget(['optionNew'=>[
        'search' => false,
        'pjax' => ['id' => 'pjax_product_items_main1','enablePushState' => false],
        'pageSize' =>'3',
        'breadcrumbs' =>false,
        'isPage' =>false,
        'andWhere' => [ 'status' => 1],
    ]]);
    ?>
    </div>
    <div class="WidgetProductItems">
    <?
    echo app\widgets\video\WidgetVideoItems::widget(['optionNew'=>[
        'search' => false,
        'pjax' => ['id' => 'pjax_video_items_main1','enablePushState' => false],
        'pageSize' =>'8',
        'breadcrumbs' =>false,
        'isPage' =>false,
        'andWhere' => [ 'status' => 1],
    ]]);
    ?>
    </div>
    <div class="WidgetProductItems">
    <?
    echo app\widgets\statya\WidgetStatyaItems::widget(['optionNew'=>[
        'search' => false,
        'pjax' => ['id' => 'pjax_statya_items_main1','enablePushState' => false],
        'pageSize' =>'10000',
        'breadcrumbs' =>false,
        'isPage' =>false,
        'andWhere' => [ 'status' => 1],
    ]]);
    ?>
    </div>
    <? } */?>
</div>
