<?php

namespace app\modules\testbuilder\controllers;

use yii\web\Controller;
use app\modules\testbuilder\models\BuilderPage;
use app\modules\testbuilder\models\BuilderBlocks;
use app\modules\testbuilder\models\BuilderBlockHtml;

class AjaxController extends Controller
{
    public function actionAddBlockHtml($page_id, $title, $title_head, $title_color, $class, $border, $code)
    {
        if (\Yii::$app->request->isAjax) {

            $block_html = new BuilderBlockHtml();
            $block_html->code = $code;
            $block_html->border = $border;
            $block_html->save();

            $block = new BuilderBlocks();
            $block->title = $title;
            $block->page_id = $page_id;
            $block->title_head = $title_head;
            $block->title_color = $title_color;
            $block->builder_table = 'blok_html';
            $block->builder_id = $block_html->id;
            $block->class = $class;
            $block->save();

            return $this->redirect('/testbuilder/default/view?id=' . $page_id);

        } else {
            return $this->redirect('/');
        }
    }

    public function actionUpdatePage($id, $title, $desc, $class, $seo_t, $seo_d, $seo_k, $foot, $js, $style)
    {
        if (\Yii::$app->request->isAjax) {
            $page = BuilderPage::findOne($id);
            $page->title = $title;
            $page->description = $desc;
            $page->class = $class;
            $page->seo_title = $seo_t;
            $page->seo_desc = $seo_d;
            $page->seo_key = $seo_k;
            $page->footer_html = $foot;
            $page->js = $js;
            $page->style = $style;
            $page->update();
            return true;

        } else {
            return $this->redirect('/');
        }
    }

    public function actionDeleteBlock($id){
        $block = BuilderBlocks::findOne($id);
        $block->delete();
    }

    public function actionDuplicateBlock($id){
        if (\Yii::$app->request->isAjax) {
            $block_old = BuilderBlocks::findOne($id);

            $block = new BuilderBlocks();
            $block->title = $block_old->title;
            $block->page_id = $block_old->page_id;
            $block->title_head = $block_old->title_head;
            $block->title_color = $block_old->title_color;
            $block->class = $block_old->class;

            if($block_old->builder_table == 'blok_html') {
                $block_html_old = BuilderBlockHtml::findOne($block_old->builder_id);
                $block_html = new BuilderBlockHtml();
                $block_html->code = $block_html_old->code;
                $block_html->border = $block_html_old->border;
                $block_html->save();

                $block->builder_id = $block_html->id;
                $block->builder_table = 'blok_html';
            }
            $block->save();

            return $this->redirect('/testbuilder/default/view?id=' . $block_old->page_id);

        } else {
            return $this->redirect('/');
        }
    }

    public function actionSaveBlock($page_id, $title = '', $title_head = '', $title_color = '', $class = '', $id)
    {
        if (\Yii::$app->request->isAjax) {

            $block = BuilderBlocks::findOne($id);
            $block->title = $title;
            $block->page_id = $page_id;
            $block->title_head = $title_head;
            $block->title_color = $title_color;
            $block->class = $class;
            $block->save();

            return true;

        } else {
            return $this->redirect('/');
        }
    }
}