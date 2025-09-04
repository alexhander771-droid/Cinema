<?php
use hail812\adminlte3\widgets\Menu;
use yii\helpers\Html;
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  
   <a href="<?= Yii::$app->homeUrl ?>" class="brand-link" style="text-decoration: none;">
    <span class="brand-text font-weight-light">Cinema</span>
</a>

  
    <div class="sidebar">

        <nav class="mt-2">
            <?= Menu::widget([
                'items' => [
                    [
                        'label' => 'Афиша',
                        'icon' => 'home',
                        'url' => ['/site/index']
                    ],
                    [
                        'label' => 'Админка', 
                        'icon' => 'calendar',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Фильмы',
                                'icon' => 'video',
                                'url' => ['/film/index']
                            ],
                            [
                                'label' => 'Сеансы',
                                'icon' => 'clock',
                                'url' => ['/session/index']
                            ],
                            [
                                'label' => 'Новый сеанс',
                                'icon' => 'plus-circle',
                                'url' => ['/session/create']
                            ]
                        ]
                    ],
                    [
                        'label' => 'Выйти',
                        'icon' => 'sign-out-alt',
                        'url' => ['/site/logout'],
                        'template' => '<a href="{url}" data-method="post">{icon} {label}</a>'
                    ]
                ]
            ]) ?>
        </nav>
    </div>
</aside>