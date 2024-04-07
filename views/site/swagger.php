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

    .exec-query {
        padding: 20px;
        margin-top: -20px;
        margin-bottom: 20px;
        background-color: #d8d8d8;
        border-radius: 10px;
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
        <?= Html::button('Выполнить тестовый запрос',
            ['class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 20px', 'id' => 'b1', 'onclick' => 'showQuery("b1")']) ?>
    </div>
</div>
<div id="d1" style="display: none" class="exec-query">
    <b>Запрос:</b> /internal-api/get-checkin-user-to-point?userId=1&pointId=1&routeId=1<br>
    <b>Ответ:</b><br>
    [<br>
    'status': 'true',<br>
    'check': 'passed',<br>
    ]<br>
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
        <?= Html::button('Выполнить тестовый запрос',
            ['class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 20px', 'id' => 'b2', 'onclick' => 'showQuery("b2")']) ?>
    </div>
</div>
<div id="d2" style="display: none" class="exec-query">
    <b>Запрос:</b> /internal-api/get-current-user-route-state?userId=1&routeId=1<br>
    <b>Ответ:</b><br>
    [<br>
    'status': 'true',<br>
    'checkin-array': [<br>
    &nbsp;&nbsp;&nbsp;&nbsp;1: 'passed',<br>
    &nbsp;&nbsp;&nbsp;&nbsp;2: 'passed',<br>
    &nbsp;&nbsp;&nbsp;&nbsp;3: 'miss'<br>
    &nbsp;&nbsp;],<br>
    ]<br>
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
        <?= Html::button('Выполнить тестовый запрос',
            ['class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 20px', 'id' => 'b3', 'onclick' => 'showQuery("b3")']) ?>
    </div>
</div>
<div id="d3" style="display: none" class="exec-query">
    <b>Запрос:</b> /internal-api/get-qr-link?routeId=1&pointId=1<br>
    <b>Ответ:</b><br>
    [<br>
    'status': 'true',<br>
    'link': /qr/check-point?rpuId=1,<br>
    ]<br>
</div>

<div class="swagger-wrapper">
    <div class="swagger-text">
        <span class="query-type">GET</span><b><span class="title-text">Запрос на получение всех выполненных пользователем заданий:</span> <span class="code-text">/internal-api/get-user-complete-tasks</span></b><br>
        <hr>
        <span style="font-size: 18px; line-height: 2">Параметры:</span><br>
        - <span class="code-text" style="line-height: 2">userId</span>: id пользователя<br>
    </div>
    <div class="swagger-brn">
        <?= Html::button('Выполнить тестовый запрос',
            ['class' => 'btn btn-success', 'style' => 'width: 100%; margin-top: 20px', 'id' => 'b4', 'onclick' => 'showQuery("b4")']) ?>
    </div>
</div>
<div id="d4" style="display: none" class="exec-query">
    <b>Запрос:</b> /internal-api/get-user-complete-tasks?userId=<br>
    <b>Ответ:</b><br>
    [<br>
    'status': 'true',<br>
    'data': [<br>
    &nbsp;&nbsp;&nbsp;&nbsp;['route_id': 1, 'task_id': 1],<br>
    &nbsp;&nbsp;&nbsp;&nbsp;['route_id': 1, 'task_id': 2],<br>
    &nbsp;&nbsp;&nbsp;&nbsp;['route_id': 2, 'task_id': 3],<br>
    &nbsp;&nbsp;],<br>
    ]<br>
</div>


<script>
    function showQuery(id)
    {
        if (id === 'b1') {
            document.getElementById('d1').style.display = "block";
        } else if (id === 'b2') {
            document.getElementById('d2').style.display = "block";
        } else if (id === 'b3') {
            document.getElementById('d3').style.display = "block";
        } else if (id === 'b4') {
            document.getElementById('d4').style.display = "block";
        }
    }
</script>