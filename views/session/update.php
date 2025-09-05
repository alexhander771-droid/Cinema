<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Session $model */
/** @var array $films */

$this->title = 'Редактировать сеанс: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Сеансы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="session-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'films' => $films,
    ]) ?>

</div>
