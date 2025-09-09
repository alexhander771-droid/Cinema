<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Film $model */

$this->title = 'Создать фильм';
$this->params['breadcrumbs'][] = ['label' => 'Фильмы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="film-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
