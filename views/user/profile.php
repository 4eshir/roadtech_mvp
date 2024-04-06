<?php

use app\models\Route;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->login;
\yii\web\YiiAsset::register($this);

?>
<div class="route-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'login',
            'russpass_balance',
            'money_balance',
            'status',
        ],
    ]) ?>
