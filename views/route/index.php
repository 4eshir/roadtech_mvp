<?php

use app\models\route;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Route[] $routes */

$this->title = 'Мои маршруты';
$this->params['breadcrumbs'][] = $this->title;

$script = "$(document).ready(function() {
        $('#open-modal-btn').click(function() {
            $('#additional-modal').modal('show');
        });
    });";
$this->registerJs($script, View::POS_READY);

$this->registerCssFile('/css/roads.css');
?>

<div class="route-index">
    <?php $form = ActiveForm::begin(); ?>
    <h2><?= Html::encode($this->title) ?></h2>

    <div class="section-link">
        <a href="#">Избранное</a>
        <a href="#">Поездки</a>
        <a href="#">Рекомендации</a>
    </div>

    <?php
    $data = [
        '1' => 'Москва',
        '2' => 'Санкт-Петербург',
        '3' => 'Калининград',
        '4' => 'Сочи',
    ];

    // Опции для выпадающего списка
    $options = ['prompt' => 'Все направления'];

    // Вывод выпадающего списка
    echo Html::dropDownList('select', null, $data, $options);
    ?>

    <?php
    $data = [
        '1' => 'Туристическая',
        '2' => 'Семейная',
        '3' => 'На велосипеде',
        '4' => 'Историческая',
    ];

    // Опции для выпадающего списка
    $options = ['prompt' => 'Тематика'];

    // Вывод выпадающего списка
    echo Html::dropDownList('select', null, $data, $options);
    ?>

    <div class="row">
        <?php foreach ($routes as $route): ?>
        <div class="col-md-4 col-sm-6 cards">
            <div class="card-rout">
                <div class="social flexx space">
                    <div class="rating">7.4</div>
                    <div class="like"><img src="mark/icons8-лайк-с-заливкой-24.png"></div>
                </div>
                <div class="picture"></div>
                <div class="text-area">
                    <div class="city"><?= $route->name; ?></div>
                    <div class="info">
                        <div class="info-city"><img class="mark-card" src="/mark/icons8-visit-50.png">Астрахань</div>
                        <div class="days"><img class="mark-card" src="/mark/icons8-время-24.png">1 день</div>
                        <div class="dots"><img class="mark-card" src="/mark/icons8-флаг-2-24.png"><?= $route->pointsCount(); ?> мест</div>
                    </div>
                    <div class="btn-area">
                        <div class="btn-rout">
                            <?= Html::a('Посмотреть', Url::to(['view', 'id' => $route->id]), ['class' => 'btn-rout-link']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>


    <?php
    /*$items = ['Москва', 'Санкт-Петербург', 'Калининград', 'Сочи'];

    Modal::begin([
        'title' => '<h2>Дополнительное окно</h2>',
        'id' => 'additional-modal',
        'size' => 'modal-lg',
    ]);

    // Ваше содержимое модального окна
    echo 'Здесь может быть ваше содержимое модального окна';

    Modal::end();*/
    ?>

    <?php /*echo Html::button('Открыть дополнительное окно', ['class' => 'btn btn-primary', 'id' => 'open-modal-btn'])*/ ?>

    <div>
        <p>
            <?= Html::a('Create Route', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>



    <div>
        <?php
        $counter = 0;
        foreach ($routes as $route): ?>
        <?php if ($counter == 3): ?>
        <?php $counter = 0; ?>
    </div>
    <div>
        <?php endif; ?>


        <div class="card-route">
            <?= $route->name; ?>
            <?= Html::a('Посмотреть', Url::to(['view', 'id' => $route->id]), ['class' => 'btn btn-primary']); ?>
        </div>
        <?php endforeach; ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
