<?php

use app\models\Session;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\search\SessionSearch $searchModel */
/** @var array $films */

$this->title = 'Сеансы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="session-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Создать сеанс', ['create'], ['class' => 'btn btn-secondary']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'film_id',
                'value' => function (Session $model) {
                    return $model->film ? $model->film->title : 'Не указан';
                },
                'filter' => $films
            ],
            'start_at',
            'price',
            [
                'class' => 'yii\grid\ActionColumn',
                'visible' => !Yii::$app->user->isGuest,
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

</div>