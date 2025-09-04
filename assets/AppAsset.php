<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/adminlte-custom.css' 
    ];
    
    public $js = [
        'js/site.js',
        'js/adminlte-custom.js' 
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'hail812\adminlte3\assets\AdminLteAsset', 
    ];
}