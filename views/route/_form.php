<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\forms\RouteForm $model */
/** @var yii\bootstrap5\ActiveForm $form */

$this->registerCssFile('./css/roads.css');
$this->registerCss('
    .route-form {
        font-size: 1.5em!important;
    }
    .form-group button {
        margin: 2em 0;
    }
    .map {
        background: url("./img/map-create.png") no-repeat;
        background-size: 90%;
        width: 50%;
    }
    .map:hover {
        background: url("./img/map-hover.png") no-repeat;
        background-size: 70%;
    }
');
?>

<div class="flexx space">
    <div class="route-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'level')->dropDownList([
            '1' => 'Легкий',
            '2' => 'Средний',
            '3' => 'Сложный',
        ]) ?>

        <?= $form->field($model, 'type')->dropDownList([
            '10' => 'Туристический',
            '20' => 'Семейный с детьми',
            '30' => 'Кому слегка за 20',
            '40' => 'Романтическая прогулка',
        ]) ?>

        <?= $form->field($model, 'pointIds')->checkboxList($model->pointList, ['separator' => '<br>']) ?>

        <?= Html::checkbox('name', false, ['label' => 'Отправить маршрут на публикацию в RUSSPASS']) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить в маршрут', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <div class="map"></div>
</div>

