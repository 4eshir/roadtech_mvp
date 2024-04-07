<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'RUSSPASS';

$script = "$(document).ready(function(){
    $('#openModalButton').click(function() {
        $('#modal').modal('show');
    });
});";
$this->registerJs($script, View::POS_READY);
?>
<div class="site-index">
    <div class="btn-test">
        <div class="btn-rout-main btn-rout-link-main">
            <button id="openModalButton" class="btn-rout-link-main button-main">Подобрать маршрут</button>
        </div>
    </div>

    <?php
    // Получаем HTML-код страницы
    $html = file_get_contents(Url::home(true).Url::to(['/route/questionnaire']));

    if (preg_match('/<main\b[^>]*>(.*?)<\/main>/s', $html, $matches)) {
        $content = $matches[1];
    }

    Modal::begin([
        //'title' => '<h3>Подбор маршрута</h3>',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo '<div class="modalContent">' . $content . '</div>';

    Modal::end();
    ?>
</div>
