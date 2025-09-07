<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Основной asset bundle приложения
 *
 * Подключает основные CSS и JS файлы, а также зависимости
 */
class AppAsset extends AssetBundle
{
    /**
     * @var string Базовый путь к web-доступным файлам
     */
    public $basePath = '@webroot';

    /**
     * @var string Базовый URL к web-доступным файлам
     */
    public $baseUrl = '@web';

    /**
     * @var array CSS файлы для подключения
     */
    public $css = [
        'css/adminlte-custom.css'
    ];

    /**
     * @var array JS файлы для подключения
     */
    public $js = [
        'js/site.js',
        'js/adminlte-custom.js'
    ];

    /**
     * @var array Зависимости от других asset bundles
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'hail812\adminlte3\assets\AdminLteAsset',
    ];
}