<?php

/** @var yii\web\View $this */
/** @var app\models\forms\QuestionnaireForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'type', ['options' => ['id' => 'q1', 'style' => 'display: block']])->radioList([
    10 => 'Туристический поход',
    20 => 'Семейная прогулка с детьми',
    30 => 'Оздоровительная прогулка',
    40 => 'Романтическая прогулка'
], ['separator' => '<br>']) ?>

<?= $form->field($model, 'level', ['options' => ['id' => 'q2', 'style' => 'display: none']])->radioList([
    1 => '<7000 шагов',
    2 => '7000 - 15000 шагов',
    3 => '15000+ шагов'
], ['separator' => '<br>']) ?>

<?= $form->field($model, 'duration', ['options' => ['id' => 'q3', 'style' => 'display: none']])->radioList([
    1 => 'В течение 1 дня',
    2 => '2 дня',
    3 => '3+ дней'
], ['separator' => '<br>']) ?>

<?= Html::a('Далее', '#', ['class' => 'btn btn-primary', 'onclick' => 'showNext()', 'id' => 'nextBtn']) ?>

<div class="form-group">
    <?= Html::submitButton('Создать маршрут', ['class' => 'btn btn-success', 'id' => 'finalBtn', 'style' => 'display: none']) ?>
</div>

<?php ActiveForm::end(); ?>

<script>
    function showNext()
    {
        let q1 = document.getElementById('q1');
        let q2 = document.getElementById('q2');
        let q3 = document.getElementById('q3');
        let final = document.getElementById('finalBtn');
        let next = document.getElementById('nextBtn');

        if (q1.style.display === "block") {
            q2.style.display = "block";
            q1.style.display = "none";
            q3.style.display = "none";
        } else if (q2.style.display === "block") {
            q2.style.display = "none";
            q1.style.display = "none";
            q3.style.display = "block";
            final.style.display = "block";
            next.style.display = "none";
        }
    }
</script>
