<?php
$this->registerMetaTag(['keywords' => Yii::t('app', 'Products').' '.yii::$app->params['mainTitle']]);
$this->registerMetaTag(['description' => Yii::t('app', 'Products').' '.yii::$app->params['mainTitle']]);
echo app\widgets\product\WidgetProductItems::widget([
        'optionNew' => [
            'pageSize' => 0,
        ]
    ]);
?>