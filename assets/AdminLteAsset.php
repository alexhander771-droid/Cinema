<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle для AdminLTE 3
 *
 * Подключает основные CSS и JavaScript файлы AdminLTE 3
 * с зависимостями от Bootstrap и Yii assets
 */
class AdminLteAsset extends AssetBundle
{
    /**
     * @var string Путь к исходным файлам AdminLTE
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte';

    /**
     * @var array CSS файлы AdminLTE
     */
    public $css = [
        'dist/css/adminlte.min.css',
    ];

    /**
     * @var array JavaScript файлы AdminLTE
     */
    public $js = [
        'dist/js/adminlte.min.js'
    ];

    /**
     * @var array Зависимости от других asset bundles
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}