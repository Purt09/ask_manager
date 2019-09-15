<?php

namespace admin\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    //public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

//        '/admin_public/public/css/site.css',
//        '/public/css/realty.css',
        // 'plugin/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css',
        // 'plugin/datetimepicker/jquery.datetimepicker.css',
        'plugin/datetimepicker2/css/bootstrap-datetimepicker.css',
        // 'plugin/datetimepicker2/css/datetimepicker-kv.csss',
        
        
        'css/global.css?20170722',
    ];
    public $js = [
        'plugin/scrollup-master/dist/jquery.scrollUp.min.js',   
        // 'plugin/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js', 
        // 'plugin/datetimepicker/jquery.datetimepicker.js',
        'plugin/datetimepicker2/js/bootstrap-datetimepicker.js',
        'plugin/datetimepicker2/js/locales/bootstrap-datetimepicker.ru.js',
        
        
        'plugin/jquery.maskedinput.min.js', 
        'js/main.js?20171121',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yiister\adminlte\assets\Asset',
        'mdm\admin\AnimateAsset',
        'mdm\admin\AutocompleteAsset',
    ];
}
