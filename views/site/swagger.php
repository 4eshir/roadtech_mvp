<?php

use yii\helpers\Html; ?>

<style>
    .code-text {
        font-family: Consolas;
        background-color: #d8d8d8;
        border-radius: 5px;
        padding: 5px;
    }

    .title-text {
        font-size: 20px;
    }

    .swagger-wrapper {
        border: 1px solid darkgreen;
        border-radius: 10px;
        padding: 10px;
        background-color: rgba(52, 255, 52, 0.34);
        margin-bottom: 20px;
    }

    .query-type {
        background-color: #0a3622;
        color: white;
        padding: 5px;
        border-radius: 5px;
        margin-right: 10px;
    }
</style>

<h1>Swagger Internal API</h1><br>

<div class="swagger-wrapper">
    <div class="swagger-text">
        <span class="query-type">GET</span><b><span class="title-text">Запрос на чекин пользователя в точке:</span> <span class="code-text">/internal-api/get-checkin-user-to-point</span></b><br>
        <hr>
        <span style="font-size: 18px; line-height: 2">Параметры:</span><br>
        - <span class="code-text" style="line-height: 2">userId</span>: id пользователя<br>
        - <span class="code-text" style="line-height: 2">pointId</span>: id проверяемой точки<br>
        - <span class="code-text" style="line-height: 2">routeId</span>: id маршрута, к которому привязана точка<br>
    </div>
    <div class="swagger-brn">
        <?= Html::a('Выполнить тестовый запрос', '#', ['class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 20px']) ?>
    </div>
</div>

<div class="swagger-wrapper">
    <div class="swagger-text">
        <span class="query-type">GET</span><b><span class="title-text">Запрос на чекин пользователя по маршруту:</span> <span class="code-text">/internal-api/get-current-user-route-state</span></b><br>
        <hr>
        <span style="font-size: 18px; line-height: 2">Параметры:</span><br>
        - <span class="code-text" style="line-height: 2">userId</span>: id пользователя<br>
        - <span class="code-text" style="line-height: 2">routeId</span>: id маршрута<br>
    </div>
    <div class="swagger-brn">
        <?= Html::a('Выполнить тестовый запрос', '#', ['class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 20px']) ?>
    </div>
</div>

<div class="swagger-wrapper">
    <div class="swagger-text">
        <span class="query-type">GET</span><b><span class="title-text">Запрос на получение URL для QR-кода:</span> <span class="code-text">/internal-api/get-qr-link</span></b><br>
        <hr>
        <span style="font-size: 18px; line-height: 2">Параметры:</span><br>
        - <span class="code-text" style="line-height: 2">routeId</span>: id маршрута<br>
        - <span class="code-text" style="line-height: 2">pointId</span>: id точки<br>
    </div>
    <div class="swagger-brn">
        <?= Html::a('Выполнить тестовый запрос', '#', ['class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 20px']) ?>
    </div>
</div>
