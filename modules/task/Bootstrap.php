<?php

namespace app\modules\task;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $this->registerTranslations($app);
    }

    public function registerTranslations(Application $app)
    {
        $app->i18n->translations['modules/task/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/task/messages',
            'fileMap' => [
                'modules/task/module' => 'module.php',
            ],
        ];
    }
}
