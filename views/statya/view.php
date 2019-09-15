<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use app\models\StatyaGroup;

/* @var $this yii\web\View */
/* @var $model app\models\Statya */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statyas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statya-view">
    <div class="row">
        <div class="col-sm-8 col-sm-push-4">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

            <?/*= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'url:url',
                    'description_min:ntext',
                    'description:ntext',
                    'foto',
                    'meta_keywords',
                    'meta_description',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ])*/?>

            <div class="statyas_item">
                <div class="row">

                    <?
                    $imgs = $model->getBehavior('galleryBehavior')->getImages();
                    $img = $imgs[0];

                    if(!empty($imgs)){
                    ?>
                    <div class="col-xs-12 col-md-12 col-sm-12">
                        <div class="thumbnail">
                            <? if(!empty($img)){ ?>
                                <div class="group list-group-image"
                                     style="height: 400px;background-size: cover;background-image: url('<?=$img->getUrl('original') ;?>') "
                                     alt="<?=$img->name ;?>"
                                     title="<?=$img->description ;?>"
                                    ></div>
                            <? } ?>
                        </div>
                        <? if(count($imgs) > 2){ ?>
                            <div class="list_thumbnail">
                                <div class="row">
                                <? foreach($model->getBehavior('galleryBehavior')->getImages() as $img){ ?>
                                    <div class="col-sm-2 col-xs-3">
                                        <a class="a-thumbnail" href="<?=$img->getUrl('original')?>" 
                                            rel="fancybox"
                                            alt="<?=$img->name ;?>"
                                            title="<?=$img->description ;?>">
                                            <img src="<?=$img->getUrl('small')?>" class="img-responsive img-thumbnail">         
                                        </a>
                                    </div>
                                <? } ?>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                    <? } ?>
                    <div class="col-xs-12">
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
                            foreach ($list_groups as $key => $group) { 
                                $checked = '';
                                if ($model->group_id == $group['id']) {
                                    $checked = 'checked';
                                }
                                ?>
                        <div class="statyas_item col-sm-12 col-xs-12">
                            <input id="ac-<?=$group['id']?>" name="accordion-<?=$group['id']?>" type="checkbox" <?=$checked?>/>
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