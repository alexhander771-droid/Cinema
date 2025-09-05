<?php

use yii\helpers\Html;
use yii\grid\GridView;



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

    <?php // TODO: что за артефакт остался?
    ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
      ['class' => 'yii\grid\SerialColumn'],

      'id',
      [
        'attribute' => 'film_id',
        'value' => function ($model) {
          return $model->film ? $model->film->title : 'Не указан';
        },
        'filter' => \yii\helpers\ArrayHelper::map(\app\models\Film::find()->all()//TODO: исправить
                , 'id', 'title')
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