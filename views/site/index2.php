<?php
/* @var $this yii\web\View */
?>
<div class="site-index">
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
</div>