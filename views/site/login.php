<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;



$this->title = 'Вход в админку';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
  <h1><?= Html::encode($this->title) ?></h1>

  <p>Пожалуйста, заполните следующие поля для входа:</p>

  <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

  <?= $form->field($model, 'ваше имя')->textInput(['autofocus' => true]) ?>

  <?= $form->field($model, 'пароль')->passwordInput() ?>

  <?= $form->field($model, 'запомнить')->checkbox() ?>

  <div class="form-group">
    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>