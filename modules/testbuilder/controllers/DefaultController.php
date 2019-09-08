<?php

namespace app\modules\testbuilder\controllers;

use app\modules\testbuilder\models\BuilderBlocks;
use yii\web\Controller;
use app\modules\testbuilder\models\BuilderPage;
use app\modules\testbuilder\models\BuilderBlockHtml;

/**
 * Default controller for the `testbuilder` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionView($id)
    {
        $page = BuilderPage::findOne($id);

        $blocks = $page->getBuilderBlocks()->indexBy('id')->orderBy('position')->all();
        foreach ($blocks as $block)
        if($block['builder_table'] == 'blok_html')
            $block['builder_id'] = BuilderBlockHtml::find()->where(['id' => $block['builder_id']])->asArray()->one();
        return $this->render('view', [
            'page' => $page,
            'blocks' => $blocks,
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($id)
    {
        $page = BuilderPage::findOne($id);

        $blocks = $page->getBuilderBlocks()->indexBy('id')->orderBy('position')->all();
        foreach ($blocks as $block)
            if($block['builder_table'] == 'blok_html')
                $block['builder_id'] = BuilderBlockHtml::find()->where(['id' => $block['builder_id']])->asArray()->one();
        return $this->render('index', [
            'page' => $page,
            'blocks' => $blocks,
        ]);
    }
}
