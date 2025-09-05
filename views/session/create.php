<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Session $model */
/** @var array $films */

$this->title = 'Создать сеанс';
$this->params['breadcrumbs'][] = ['label' => 'Сеансы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="session-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'films' => $films,
    ]) ?>

</div>
