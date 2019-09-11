<?php

namespace app\modules\testbuilder\controllers;

use yii\web\Controller;
use app\modules\testbuilder\models\BuilderPage;
use app\modules\testbuilder\models\BuilderBlocks;
use app\modules\testbuilder\models\BuilderBlockHtml;

class AjaxController extends Controller
{
    // БЛОКИ
    /**
     * @param $id
     * @param $title
     * @param $title_h
     * @param $title_color
     * @return bool|\yii\web\Response
     */
    public function actionBlockSaveTitle($id, $title, $title_h, $title_color){
        if (\Yii::$app->request->isAjax) {
            $block = BuilderBlocks::findOne($id);
            $block->title = $title;
            $block->title_head = $title_h;
            $block->title_color = $title_color;
            return $block->save();
        } else {
            return $this->redirect('/');
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionBlockDuplicate($id)
    {
        if (\Yii::$app->request->isAjax) {
            $block_old = BuilderBlocks::findOne($id);

            $block = new BuilderBlocks();
            $block->title = $block_old->title;
            $block->page_id = $block_old->page_id;
            $block->title_head = $block_old->title_head;
            $block->title_color = $block_old->title_color;
            $block->class = $block_old->class;

            if ($block_old->builder_table == 'blok_html') {
                $block_html_old = BuilderBlockHtml::findOne($block_old->builder_id);
                $block_html = new BuilderBlockHtml();
                $block_html->code = $block_html_old->code;
                $block_html->border = $block_html_old->border;
                $block_html->save();

                $block->builder_id = $block_html->id;
                $block->builder_table = 'blok_html';
            }
            $block->save();
            return $this->redirect('/testbuilder/default/index?id=' . $block_old->page_id);
        } else {
            return $this->redirect('/');
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionBlockDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
        $block = BuilderBlocks::findOne($id);
        $page_id = $block->page_id;
        $block->delete();
        return $this->redirect('/testbuilder/default/index?id=' . $page_id);
        } else {
            return $this->redirect('/');
        }
    }

    /**
     * @param $id
     * @param $code
     * @param $border
     * @return bool|\yii\web\Response
     */
    public function actionBlockHtmlSave($id, $code, $border)
    {
        if (\Yii::$app->request->isAjax) {
            $block = BuilderBlockHtml::findOne($id);
            $block->code = $code;
            $block->border = $border;
            return $block->save();
        } else {
            return $this->redirect('/');
        }
    }

    /**
     * @param $page_id
     * @param $title
     * @param $title_head
     * @param $title_color
     * @param $class
     * @param $border
     * @param $code
     * @return \yii\web\Response
     */
    public function actionBlockHtmlAdd($page_id, $title = 'Заголовок', $title_head = 'h2', $title_color, $class ='', $border = 0, $code ='')
    {
        if (\Yii::$app->request->isAjax) {
            $block_html = new BuilderBlockHtml();
            $block_html->code = $code;
            if ($border == 'true')
                $block_html->border = 1;
            else
                $block_html->border = 0;
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

            $block->position = $block->id;
            $block->save();

            return $this->redirect('/testbuilder/default/index?id=' . $page_id);

        } else {
            return $this->redirect('/');
        }
    }

    public function actionBlockChangePos($pos1, $pos2){
        if (\Yii::$app->request->isAjax) {

            $block1 = BuilderBlocks::findOne($pos1);
            $block2 = BuilderBlocks::findOne($pos2);

            $pos = $block1->position;
            $block1->position = $block2->position;
            $block2->position= $pos;
            $block1->save();
            $block2->save();
            return $this->redirect('/testbuilder/default/index?id=' . $block1->page_id);

        } else {
            return $this->redirect('/');
        }
    }

    /**
     * @param $id
     * @param $title
     * @param $desc
     * @param $class
     * @param $seo_t
     * @param $seo_d
     * @param $seo_k
     * @param $foot
     * @param $js
     * @param $style
     * @return bool|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
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

    /**
     * @param $page_id
     * @param string $title
     * @param string $title_head
     * @param string $title_color
     * @param string $class
     * @param $id
     * @return bool|\yii\web\Response
     */
    public function actionSaveBlock($page_id, $title = '', $title_head = '', $title_color = '', $class = '', $id, $mt  = '', $mb  = '', $isCont = '', $isLink = '', $link_title = '')
    {
        if (\Yii::$app->request->isAjax) {

            $block = BuilderBlocks::findOne($id);
            $block->title = $title;
            $block->title = $title;
            $block->page_id = $page_id;
            $block->title_head = $title_head;
            $block->title_color = $title_color;
            $block->class = $class;
            $block->style_margin_top = $mt;
            $block->style_margin_bottom = $mb;
            ($isCont == 'true') ? $block->css_isContainer = 1 : $block->css_isContainer = 0;
            ($isLink == 'true') ? $block->isLink = 1: $block->isLink = 0;
            ($link_title == 'null') ? $block->link_title = ' ' : $block->link_title = $link_title;
            $block->save();

            return true;

        } else {
            return $this->redirect('/');
        }
    }
}