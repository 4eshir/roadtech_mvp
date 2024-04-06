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

?>

<div>
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
            <?= Html::a('Открыть', Url::to(['view', 'id' => $route->id]), ['class' => 'btn btn-primary']); ?>
        </div>
        <?php endforeach; ?>
    </div>

</div>
