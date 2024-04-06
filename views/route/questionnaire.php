<?php

/** @var yii\web\View $this */
/** @var app\models\forms\QuestionnaireForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(); ?>

<div id="q1" style="display: block">
    <?= $form->field($model, 'type')->radioList([
        10 => 'Туристический поход',
        20 => 'Семейная прогулка с детьми',
        30 => 'Оздоровительная прогулка',
        40 => 'Романтическая прогулка'
    ]) ?>
</div>

<div id="q2"  style="display: none">
    <?= $form->field($model, 'level')->radioList([
        1 => '<7000 шагов',
        2 => '7000 - 15000 шагов',
        3 => '15000+ шагов'
    ]) ?>
</div>

<div id="q3" style="display: none">
    <?= $form->field($model, 'duration')->radioList([
        1 => 'В течение 1 дня',
        2 => '2 дня',
        3 => '3+ дней'
    ]) ?>
</div>


<?= Html::a('Далее', '#', ['class' => 'btn btn-link-main', 'onclick' => 'showNext()', 'id' => 'nextBtn']) ?>

<div class="form-group">
    <?= Html::submitButton('Создать маршрут', ['class' => 'btn btn-link-main', 'id' => 'finalBtn', 'style' => 'display: none']) ?>
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
