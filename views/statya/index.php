<?php
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::t('app', 'Statyas').' '.yii::$app->params['mainTitle']]);
$this->registerMetaTag(['name' => 'description', 'content'  => Yii::t('app', 'Statyas').' '.yii::$app->params['mainTitle']]);
echo app\widgets\statya\WidgetStatyaItems::widget(['optionNew'=>[
        'pageSize' =>'20'
    ]]);
?>

<!--
$this->registerMetaTag(['keywords' => Yii::t('app', 'Statyas').' '.yii::$app->params['mainTitle']]);
$this->registerMetaTag(['description' => Yii::t('app', 'Statyas').' '.yii::$app->params['mainTitle']]);
-->