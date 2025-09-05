<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Session $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Сеансы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="session-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'film.title',
            'start_at:datetime',
            'price:currency',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
