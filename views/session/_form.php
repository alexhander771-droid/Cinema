<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Film;

?>

<div class="session-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'film_id')->dropDownList(
    ArrayHelper::map(Film::find()->all(), 'id', 'title'),
    ['prompt' => 'Выберите фильм']
  ) ?>

  <?= $form->field($model, 'start_at')->textInput(['type' => 'datetime-local']) ?>

  <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

  <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-secondary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>