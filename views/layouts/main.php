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
    <?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">
 
    <?= $this->render('_navbar') ?>
    

    <?= $this->render('_sidebar') ?>


    <div class="content-wrapper">

        <div class="content">
            <div class="container-fluid">
                <?= $content ?>
            </div>
        </div>
    </div>


    <footer class="main-footer">
        <strong>Copyright &copy; <?= date('Y') ?> Кинотеатр.</strong> Все права защищены.
    </footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>