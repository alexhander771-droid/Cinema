<?php

use hail812\adminlte3\assets\AdminLteAsset;
use yii\helpers\Html;

AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-dark bg-secondary">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    </nav>


    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="<?= Yii::$app->homeUrl ?>" class="brand-link">
            <span class="brand-text font-weight-light">Cinema</span>
        </a>

 
        <div class="sidebar">
        
            <nav class="mt-2">
                <?= \hail812\adminlte3\widgets\Menu::widget([
                    'items' => [
                        [
                            'label' => 'Афиша',
                            'icon' => 'home',
                            'url' => ['/site/index']
                        ],
                        [
                            'label' => 'Админка', 
                            'icon' => 'calendar',
                            'url' => ['/session/index']
                        ]
                       
                    ]
                ]) ?>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
  
        

        <section class="content">
            <div class="container-fluid">
                <?= $content ?>
            </div>
        </section>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>