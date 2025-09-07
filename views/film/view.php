<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Film $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Films', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php
echo "User ID: " . Yii::$app->user->id . "<br>";
echo "Is guest: " . (Yii::$app->user->isGuest ? 'Да' : 'Нет') . "<br>";
echo "Username: " . Yii::$app->user->identity->username . "<br>";
?>
<div class="film-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['update', 'id' => $model->id], ['class' => 'btn bg-secondary ']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn bg-secondary',
            'data' => [
                'confirm' => 'Удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'photo_ext',
            'description:ntext',
            'duration',
            'age_restriction',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>