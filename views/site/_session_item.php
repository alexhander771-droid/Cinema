<?php

use yii\grid\GridView;
use app\assets\AppAsset;
use app\widgets\Alert;

?>
<div class="session-item" style="border: 1px solid #585757ff; padding: 15px; margin-bottom: 15px; border-radius: 5px;">

  <?php if ($model->film->getImageUrl()): ?>
    <img src="<?= $model->film->getImageUrl() ?>" height="150" style="float: left; margin-right: 15px; margin-bottom: 15px;">
  <?php endif; ?>

  <p><strong>Описание:</strong> <?= Html::encode($model->film->description) ?></p>
  <p><strong>Время начала:</strong> <?= Yii::$app->formatter->asDatetime($model->start_at) ?></p>
  <p><strong>Продолжительность:</strong> <?= $model->film->duration ?> минут</p>
  <p><strong>Возрастные ограничения:</strong> <?= Html::encode($model->film->age_restriction) ?></p>
  <p><strong>Стоимость:</strong> <?= Yii::$app->formatter->asCurrency($model->price) ?></p>

  <div style="clear: both;"></div>
</div>