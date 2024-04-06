<?php

/** @var yii\web\View $this */
/** @var app\models\Route $model */
/** @var app\models\forms\RouteCommentForm $commentForm */
/** @var app\models\forms\RouteCommentForm $commentAnswerForm */
/** @var app\models\RouteComment[] $commentsList */

use app\models\RouteComment;
use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<style>
    .main-div {
        width: 80%;
        min-height: 20em;
        border: 1px solid red
    }

    .wrapper {
        /*здесь надо выровнять по центру*/
        margin: 0 auto;
    }
</style>

<div class="wrapper">
    <div class = "main-div">
        <?= $model->name; ?>
    </div>
</div>
<p>Лайков: <?= $model->likes ?></p>
<?= Html::a('Лайкнуть', Url::to(['/social/like-route', 'id' => $model->id]), ['class' => 'btn btn-success']) ?>

<?php $form = ActiveForm::begin(['action' => 'index.php?r=social/send-comment', 'method' => 'POST']); ?>

<?= $form->field($commentForm, 'text')->textInput() ?>
<?= $form->field($commentForm, 'routeId')->hiddenInput(['value' => $model->id])->label(false) ?>
<?= $form->field($commentForm, 'userId')->hiddenInput(['value' => User::getCurrentUser()->id])->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Комментировать', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<h2>Комментарии</h2>
<?php foreach ($commentsList as $comment): ?>
    <div>
        <?= $comment->user->login.': '.$comment->text ?><button onclick="toggleAnswerBlock(this, <?= $comment->id ?>)">Ответить</button>
        <div id="answer-block-<?= $comment->id ?>" style="display: none">
            <?php $form = ActiveForm::begin([
                    'action' => 'index.php?r=social/send-comment',
                    'method' => 'POST'
            ]); ?>

            <?= $form->field($commentAnswerForm, 'text')->textInput() ?>
            <?= $form->field($commentAnswerForm, 'routeId')->hiddenInput(['value' => $model->id])->label(false) ?>
            <?= $form->field($commentAnswerForm, 'userId')->hiddenInput(['value' => User::getCurrentUser()->id])->label(false) ?>
            <?= $form->field($commentAnswerForm, 'answerTo')->hiddenInput(['value' => $comment->id])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('Комментировать', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?php
    $subComments = RouteComment::find()->where(['answer_to' => $comment->id])->all();
    ?>
    <?php foreach ($subComments as $subComment): ?>
        <div>
            <?= '- '.$subComment->user->login.': '.$subComment->text ?>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>


<script>
    function toggleAnswerBlock(button, id) {
        var answerBlock = document.getElementById('answer-block-' + id);
        if (answerBlock.style.display === 'none' || answerBlock.style.display === '') {
            answerBlock.style.display = 'block';
            button.innerText = 'Закрыть';
        } else {
            answerBlock.style.display = 'none';
            button.innerText = 'Ответить';
        }
    }
</script>
