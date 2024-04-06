<?php

use app\models\Point;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use app\models\Route;
use app\models\User;
use app\models\UserRoute;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Route $model */
/** @var app\models\RoutePointUser[] $points */
/** @var app\models\Task[] $tasks */
/** @var app\models\TaskRouteUser[] $completeTasks */
/** @var app\models\forms\RouteResultForm $result */
/** @var app\models\forms\AddPointForm $addPointForm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Мои планы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$this->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->request->csrfParam]);
$this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->request->getCsrfToken()]);

$this->registerCssFile('/css/roads.css');
?>


<div class="route-view">
    <?php
    $pick = UserRoute::find()->where(['route_id' => $model->id])->andWhere(['user_id' => User::getCurrentUser()->id])->andWhere(['status' => 2])->one();
    $pickText = '';
    $bgColor = '';
    if ($pick) {
        $pickText = 'Вы проходите данный маршрут';
        $bgColor = 'bg-warning text-dark';
    }

    $end = UserRoute::find()->where(['route_id' => $model->id])->andWhere(['user_id' => User::getCurrentUser()->id])->andWhere(['status' => 3])->one();
    if ($end) {
        $pickText = 'Вы успешно завершили данный маршрут';
        $bgColor = 'bg-success text light';
    }
    ?>

    <div>
        <div class="flexx space">
            <div class="flexx">
                <div class="link-back"><a href="<?= Url::to(['route/index']) ?>"><img class="mark-card" src="/mark/icons8-стрелка-влево-30.png"></a></div>
                <div class="road-name">
                    <h1><?= Html::encode($this->title) ?></h1>
                </div>
                <div>
                    <span class="badge rounded-pill <?= $bgColor ?>"><?= $pickText ?></span>
                </div>
            </div>
            <div class="action-btn"></div>
        </div>
    </div>
    <div style="clear: both;"></div>

    <div class="section-link">
        <a href="#">О маршруте</a>
        <a href="#">Маршрут</a>
        <a href="#">Билеты и брони</a>
    </div>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'level',
            'prettyDistance',
            'type',
            [
                'attribute' => 'created_user_id',
                'format' => 'raw',
                'value' => function(Route $model) {
                    return Html::a($model->prettyCreator, Url::to(['/user/view', 'id' => $model->created_user_id]));
                }
            ],
            'likes',
        ],
    ]) ?>

    <?php
    $points = [];
    foreach (Point::find()->all() as $point)
        $points[$point->id] = $point->name;

    $form = ActiveForm::begin(['action' => 'index.php?r=route/add-point', 'method' => 'POST']); ?>

    <?= $form->field($addPointForm, 'pointId')->radioList($points) ?>
    <?= $form->field($addPointForm, 'method')->dropDownList([
        1 => 'Добавить в конец маршрута',
        2 => 'Добавить следующей точкой маршрута',
        3 => 'Добавить в оптимальное место маршрута',
    ]) ?>
    <?= $form->field($addPointForm, 'routeId')->hiddenInput(['value' => $model->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <h3>Ключевые точки маршрута</h3>

    <table class="table table-striped">
        <tr>
            <td><b>№</b></td>
            <td><b>Название</b></td>
            <td><b>Адрес</b></td>
            <td><b>QR-код</b></td>
            <td><b>Статус</b></td>
        </tr>
        <?php foreach ($points as $point): ?>
            <tr>
                <td><?= $point->routePoint->step; ?></td>
                <td><?= $point->routePoint->point->name; ?></td>
                <td><?= $point->routePoint->point->address; ?></td>
                <td>
                    <?php if ($point->routePoint->qr_code): ?>
                        <a href="<?= Url::to(['/qr/check-point', 'rpuId' => $point->id]) ?>">
                            <img width="100" height="100" src="<?= $point->routePoint->qr_code; ?>"/>
                        </a>
                    <?php endif; ?>
                </td>
                <td><?= $point->statusPretty; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Задания на маршруте</h3>

    <table class="table table-striped">
        <tr>
            <td><b>Что надо сделать?</b></td>
            <td><b>Тип вознаграждения</b></td>
            <td><b>Количество</b></td>
        </tr>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= $task->task->description; ?></td>
                <td><?= $task->task->rewardTypePretty; ?></td>
                <td><?= $task->task->reward_amount; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Выполненные задания</h3>

    <table class="table table-striped">
        <tr>
            <td><b>Название задания</b></td>
            <td><b>Получено</b></td>
        </tr>
        <?php foreach ($completeTasks as $task): ?>
            <tr>
                <td><?= $task->taskRoute->task->description; ?></td>
                <td><?= $task->taskRewardPretty; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>



    <?php if ($pickText == 'Вы успешно завершили данный маршрут'): ?>
        <?= Html::button('Показать результаты прохождения маршрута', [
            'class' => 'btn btn-primary',
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#exampleModal'
        ]);

        // Модальное окно
        Modal::begin([
            'title' => 'Результаты прохождения маршрута',
            'id' => 'exampleModal',
            'size' => Modal::SIZE_LARGE,
        ]);
        echo DetailView::widget([
            'model' => $result,
            'attributes' => [
                'allTasks',
                'completedTasks',
                'allPoints',
                'completedPoints',
                'rewards',
            ]
        ]);
        Modal::end();
        ?>
    <?php endif; ?>

</div>


<?php
$js = <<<JS
$('#modalButton').click(function(){
    $('#modal').modal('show');
});
JS;

$this->registerJs($js);
?>