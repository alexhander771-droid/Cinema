<?php

use hail812\adminlte3\assets\AdminLteAsset;
use yii\helpers\Html;

AdminLteAsset::register($this);

$this->title = 'Фильмы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="film-index">
    <?php if ($dataProvider->getTotalCount() === 0): ?>
        <div class="film-empty text-center py-5">
            <div class="py-5">
                <i class="fas fa-film fa-5x text-secondary mb-4"></i>
                <h3 class="text-secondary">Фильмов пока нет</h3>
                <p class="text-muted">Добавьте первый фильм в вашу коллекцию</p>
                <?= Html::a('<i class="fas fa-plus-circle"></i> Добавить фильм', ['create'], 
                    ['class' => 'btn btn-secondary btn-lg']) ?>
            </div>
        </div>
    <?php else: ?>
        <div class="mb-3">
                <h2>Фильмы</h2>
            <?= Html::a('<i class="fas fa-plus-circle"></i> Добавить фильм', ['create'], 
                ['class' => 'btn btn-secondary']) ?>
        </div>
        
        <div class="film-grid">
            <?php foreach ($dataProvider->getModels() as $film): ?>
                <div class="film-card card">
                    <?php if ($film->getImageUrl()): ?>
                        <img src="<?= $film->getImageUrl() ?>" class="film-image card-img-top" 
                             alt="<?= Html::encode($film->title) ?>">
                    <?php else: ?>
                        <div class="film-image-placeholder card-img-top" 
                             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                    height: 200px; display: flex; align-items: center; 
                                    justify-content: center; color: white; font-size: 3rem;">
                            <i class="fas fa-film"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h5 class="film-title card-title"><?= Html::encode($film->title) ?></h5>
                        
                        <div class="film-info">
                            <small class="text-muted">
                                <i class="fas fa-clock mr-1"></i>
                                <?= $film->duration ?> мин.
                            </small>
                        </div>
                        <div class="film-info">
                            <small class="text-muted">
                                <i class="fas fa-user-lock mr-1"></i>
                                <?= Html::encode($film->age_restriction) ?>
                            </small>
                        </div>
                        <div class="film-info">
                            <p class="card-text">
                                <?= mb_substr(strip_tags($film->description), 0, 100) ?>...
                            </p>
                        </div>
                        
                        <div class="film-actions d-flex justify-content-between">
                            <?= Html::a('<i class="fas fa-eye"></i> Просмотр', ['view', 'id' => $film->id], 
                                ['class' => 'film-btn btn btn-sm btn-secondary', 'title' => 'Просмотр']) ?>
                            <?= Html::a('<i class="fas fa-edit"></i> Редакт.', ['update', 'id' => $film->id], 
                                ['class' => 'film-btn btn btn-sm btn-secondary', 'title' => 'Редактировать']) ?>
                            <?= Html::a('<i class="fas fa-trash"></i> Удалить', ['delete', 'id' => $film->id], [
                                'class' => 'film-btn btn btn-sm btn-secondary',
                                'title' => 'Удалить',
                                'data' => [
                                    'confirm' => 'Удалить этот фильм?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

