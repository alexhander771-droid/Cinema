<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var TYPE_NAME $model */

?>

<div class="film-form">

  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


  $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

  <?= $form->field($model, 'imageFile')->fileInput() ?>
  <?php if (!$model->isNewRecord && $model->photo_ext): ?>
    <div class="form-group">
      <label>Текущий постер:</label>
      <div>
        <img src="<?= $model->getImageUrl() ?>" height="150px" alt="Постер фильма">
      </div>
    </div>
  <?php endif; ?>

  <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

  <?= $form->field($model, 'duration')->textInput() ?>

  <?= $form->field($model, 'age_restriction')->textInput(['maxlength' => true]) ?>

  <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success , bg-secondary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>