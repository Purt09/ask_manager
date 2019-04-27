<?php

namespace app\modules\project;

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
        $app->i18n->translations['modules/project/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/project/messages',
            'fileMap' => [
                'modules/project/module' => 'module.php',
            ],
        ];
    }
}
