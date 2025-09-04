<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\FilmSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="film-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'photo_ext') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'age_restriction') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

 

    <?php ActiveForm::end(); ?>

</div>
