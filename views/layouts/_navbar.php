<?php
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Nav;
use yii\helpers\Html;
NavBar::begin([
    'brandLabel' => 'Управление', 
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-expand navbar-dark', 
        'style' => 'background-color: #6c757d !important;' 
    ]]);



NavBar::end();
?>