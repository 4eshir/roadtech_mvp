<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\forms\RouteForm $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

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


    <div class="form-group">
        <?= Html::submitButton('Создать маршрут', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
