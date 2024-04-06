<?php

use app\models\Route;
use app\models\RoutePoint;
use app\models\Task;
use app\models\TaskRoute;
use app\models\UserRoute;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm; ?>

<h1>Welcome to the God's Panel</h1>
<hr>
<?php
$tasks = TaskRoute::find()->all();
$points = RoutePoint::find()->all();
$routes = Route::find()->all();
$routeUser = UserRoute::find()->where(['!=', 'status', 3])->all();
$tasks2 = Task::find()->all();
?>

<?php
$lastRoute = Route::find()->orderBy(['id' => SORT_DESC])->one();
?>
<?php foreach ($tasks2 as $task): ?>
    <div style="margin-bottom: 1em">
        <?= Html::a('Привязать задачу "'.$task->description.'" для маршрута '.'"'.$lastRoute->name.'"',
            Url::to(['link-task-to-route', 'routeId' => $lastRoute->id, 'taskId' => $task->id]), ['class' => 'btn btn-light']) ?>
    </div>
<?php endforeach; ?>

<hr>

<?php foreach ($tasks as $task): ?>
    <div style="margin-bottom: 1em">
        <?= Html::a('Засчитать задание "'.$task->task->description.'" на маршруте "'.$task->route->name.'" выполненным для текущего пользователя',
            Url::to(['success-task', 'trId' => $task->id]), ['class' => 'btn btn-success']) ?>
    </div>
<?php endforeach; ?>

<?php foreach ($tasks as $task): ?>
    <div style="margin-bottom: 1em">
        <?= Html::a('Засчитать задание "'.$task->task->description.'" на маршруте "'.$task->route->name.'" взятым на выполнение для текущего пользователя',
            Url::to(['take-task', 'trId' => $task->id]), ['class' => 'btn btn-primary']) ?>
    </div>
<?php endforeach; ?>

<?php foreach ($tasks as $task): ?>
    <div style="margin-bottom: 1em">
        <?= Html::a('Засчитать задание "'.$task->task->description.'" на маршруте "'.$task->route->name.'" проваленным для текущего пользователя',
            Url::to(['fail-task', 'trId' => $task->id]), ['class' => 'btn btn-danger']) ?>
    </div>
<?php endforeach; ?>

<hr>

<?php foreach ($points as $point): ?>
    <div style="margin-bottom: 1em">
        <?= Html::a('Сгенерировать QR-код для точки "'.$point->point->name.'" на маршруте "'.$point->route->name.'"',
            Url::to(['generate-qr', 'routePointId' => $point->id]), ['class' => 'btn btn-warning']) ?>
    </div>
<?php endforeach; ?>

<hr>

<?php foreach ($routes as $route): ?>
    <div style="margin-bottom: 1em">
        <?= Html::a('Привязать маршрут "'.$route->name.'" к текущему пользователю',
            Url::to(['link-route', 'routeId' => $route->id]), ['class' => 'btn btn-info']) ?>
    </div>
<?php endforeach; ?>

<hr>

<?php foreach ($routeUser as $route): ?>
    <div style="margin-bottom: 1em">
        <?= Html::a('Завершить маршрут "'.$route->route->name.'" для текущего пользователя',
            Url::to(['end-route', 'userRouteId' => $route->id]), ['class' => 'btn btn-dark']) ?>
    </div>
<?php endforeach; ?>

<hr>
