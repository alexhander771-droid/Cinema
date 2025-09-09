<?php

use hail812\adminlte3\assets\AdminLteAsset;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Расписание сеансов';

?>

<div class="site-index">

    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid bg-light py-4" style="min-height: calc(100vh - 200px);">
                <div class="container">
                    <?php if (empty($sessions)): ?>
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Сеансов нет</h5>
                            <p>На данный момент сеансы не добавлены в систему.</p>
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <?= Html::a('Добавить сеанс', ['/session/create'], ['class' => 'btn btn-secondary']) ?>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($sessions as $session): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card card-primary">
                                        <div class="card-header bg-secondary">
                                            <h3 class="card-title text-white"><?= Html::encode($session->film->title) ?></h3>
                                            <div class="card-tools">
                        <span class="badge bg-light text-dark">
                            <?= Html::encode($session->film->age_restriction) ?>
                     </span>
                                            </div>
                                        </div>

                                        <?php if ($session->film->getImageUrl()): ?>
                                            <div class="card-body p-0">
                                                <img src="<?= $session->film->getImageUrl() ?>"
                                                     class="img-fluid"
                                                     style="width: 100%; height: 200px; object-fit: cover;">
                                            </div>
                                        <?php endif; ?>

                                        <div class="card-body">
                                            <p class="card-text">
                                                <small><?= Html::encode(mb_substr($session->film->description, 0, 100)) ?>
                                                    ...</small>
                                            </p>

                                            <div class="session-details">
                                                <p><i class="fas fa-clock"></i> <strong>Начало:</strong>
                                                    <?= Yii::$app->formatter->asDatetime($session->start_at) ?>
                                                </p>
                                                <p><i class="fas fa-hourglass-half"></i> <strong>Длительность:</strong>
                                                    <?= $session->film->duration ?> мин.
                                                </p>
                                                <p><i class="fas fa-ticket-alt"></i> <strong>Цена:</strong>
                                                    <span class="badge bg-success">
                                                <?= Yii::$app->formatter->asCurrency($session->price) ?>
                                            </span>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="card-footer">


                                            <?php if (!Yii::$app->user->isGuest): ?>
                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <div class="btn-group btn-group-sm btn-block">
                                                            <?= Html::a(' Редактировать', ['/session/update', 'id' => $session->id],
                                                                ['class' => 'btn bg-light']) ?>
                                                            <?= Html::a(' Удалить', ['/session/delete', 'id' => $session->id],
                                                                [
                                                                    'class' => 'btn bg-secondary',
                                                                    'data' => [
                                                                        'confirm' => 'Удалить этот сеанс?',
                                                                        'method' => 'post',
                                                                    ]
                                                                ]) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>