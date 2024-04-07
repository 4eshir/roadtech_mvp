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
use yii\web\View;

/** @var yii\web\View $this */
/** @var app\models\Route $model */
/** @var app\models\RoutePointUser[] $points */
/** @var app\models\RoutePoint[] $pointsPure */
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

$this->registerCssFile('./css/roads.css');

$script = "$(document).ready(function(){
    $('#openModalButton').click(function() {
        $('#modal').modal('show');
    });
});";
$this->registerJs($script, View::POS_READY);

?>

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

<div id="description-container" class="block" style="display: block;">
    <div class="flexx">
        <div class="">
            <div>
                <div class="flexx space">
                    <div class="flexx">
                        <div class="link-back"><a href="<?= Url::to(['route/index']) ?>"><img class="mark-card" src="./mark/icons8-стрелка-влево-30.png"></a></div>
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
                <button onclick="toggleBlock('description-container')" id="q1">Описание</button>
                <button onclick="toggleBlock('route-container')" id="q2">Маршрут</button>
                <button onclick="toggleBlock('tickets-container')" id="q3">Билеты и бронирования</button>
                <button onclick="toggleBlock('journey-container')" id="q4">В путь</button>
            </div>

            <div class="flexx social-in-card">
                <div class="">
                    <div class="tasks">
                        <div class="btn-rout btn-rout-button">
                            <button id="openModalButton" class="btn-rout-button">Задание на маршруте</button>
                        </div>
                        <span><?= $model->tasksCount(); ?></span>
                    </div>

                    <?php

                    Modal::begin([
                        'title' => '<h3>Задание от Яндекс</h3>',
                        'id' => 'modal',
                        'size' => 'modal-lg',
                    ]);

                    echo '<div class="modalContent">'
                        . '<table class="table table-striped">
                            <tr>
                                <td><b>Что надо сделать?</b></td>
                                <td><b>Тип вознаграждения</b></td>
                                <td><b>Количество</b></td>
                            </tr>';
                            foreach ($tasks as $task)
                                {
                                    echo '<tr>
                                    <td>'.$task->task->description.'</td>
                                    <td>'.$task->task->rewardTypePretty.'</td>
                                    <td>'.$task->task->reward_amount.'</td>
                                </tr>';
                                }
                            echo '</table>'.'</div>';

                    Modal::end();
                    ?>

                </div>
                <div class="like">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                        <path class="heart" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>

                <div class="rating">7.4</div>
                <div class="rating-text">На основе <br>40 оценок</div>
            </div>
            
            <div class="discription-info">
                <img src="./img/discription-info.png">
            </div>

            <div class="dots">
                <div class="title-dots">Что вы увидите</div>
                <div class="dots-list row">
                    <?php if (count($points) > 0): ?>
                        <?php foreach ($points as $point): ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="card-rout dot-road">
                                    <div class="social flexx space">
                                        <div class="rating">7.4</div>
                                        <div class="like">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                                <path class="heart" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="picture-dot"></div>
                                    <div class="dot-info">
                                        <div class="dot-type lgc"><?= $point->routePoint->point->getPrettyType(); ?></div>
                                        <div class="dot-name"><?= $point->routePoint->point->name; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php foreach ($pointsPure as $point): ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="card-rout dot-road">
                                    <div class="social flexx space">
                                        <div class="rating">7.4</div>
                                        <div class="like">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                                <path class="heart" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="picture-dot"></div>
                                    <div class="dot-info">
                                        <div class="dot-type lgc"><?= $point->routePoint->point->getPrettyType(); ?></div>
                                        <div class="dot-name"><?= $point->routePoint->point->name; ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="comments">
                <div class="title-dots">Отзывы и оценки</div>
                <div class="comment-list">
                    <img src="./img/comments.png">
                </div>
            </div>
        </div>
        <div class="map2">
            <div>
                <img src="./img/map1.png">
            </div>
            <div class="calendar">
                <div class="calendar-text">Доступность маршрута</div>
                <div style="text-align: right;">
                    <?php
                    $data = [
                        '1' => 'Январь',
                        '2' => 'Февраль',
                        '3' => 'Март',
                        '4' => 'Апрель',
                        '5' => 'Май',
                        '6' => 'Июнь',
                        '7' => 'Июль',
                        '8' => 'Август',
                        '9' => 'Сентябрь',
                        '10' => 'Октябрь',
                        '11' => 'Ноябрь',
                        '12' => 'Декабрь',
                    ];

                    // Опции для выпадающего списка
                    $options = ['prompt' => 'Апрель'];

                    // Вывод выпадающего списка
                    echo Html::dropDownList('select', null, $data, $options);
                    ?>
                </div>
                <div class="calenadar-day">
                    <img src="./img/calendar.png">
                </div>
            </div>
        </div>
    </div>

</div>
<div id="route-container" class="block" style="display: none;">
    <div class="flexx">
        <div class="route-view">
            <div>
                <div class="flexx space">
                    <div class="flexx">
                        <div class="link-back"><a href="<?= Url::to(['route/index']) ?>"><img class="mark-card" src="./mark/icons8-стрелка-влево-30.png"></a></div>
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
                <button onclick="toggleBlock('description-container')" id="q1">Описание</button>
                <button onclick="toggleBlock('route-container')" id="q2">Маршрут</button>
                <button onclick="toggleBlock('tickets-container')" id="q3">Билеты и бронирования</button>
                <button onclick="toggleBlock('journey-container')" id="q4">В путь</button>
            </div>

            <div class="road-link flexx">
                <div class="type-road-link">
                    <a href="#">
                        <img src="./mark/icons8-ходьба-50.png" class="mark-card">40 мин.
                        <span style="lgc">
                        <?php echo $model->getPrettyDistance(); ?>
                    </span>
                    </a>
                </div>
                <div class="type-road-link">
                    <a href="#">
                        <img src="./mark/icons8-автобус-50.png" class="mark-card">30 мин.
                        <span style="lgc">
                        <?php echo $model->getPrettyDistance(); ?>
                    </span>
                    </a>
                </div>
            </div>

            <div class="flexx" id="container-switch" style="margin: 1em 0;">
                <input type="checkbox" id="switch" /><label for="switch">Toggle</label>
                <span style="margin-left: 1em;">Оптимальный маршрут</span>
            </div>

            <div class="section-link">
                <a href="#">Ср, 23.04</a>
            </div>

            <div class="list-road">
                <div class="dot flexx">
                    <div class="img-prev-dot">
                        <div class="img-dot">
                            <img src="./img/dot.png">
                        </div>
                        <div class="number-dot">1</div>
                    </div>
                    <div class="info-dot">
                        <div class="info-text dgc">30 мин Площади</div>
                        <div class="name">Красная площадь</div>
                        <div class="address dgc">Красная площадь, Москва</div>
                    </div>
                </div>
                <div class="transition flexx">
                    <div class="img-transition">
                        <img src="./img/person.png">
                    </div>
                    <div class="info-transition dgc">
                        800 м, 10 мин.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tickets-container" class="block" style="display: none;">
    <div class="">
        <div>
            <div class="flexx space">
                <div class="flexx">
                    <div class="link-back"><a href="<?= Url::to(['route/index']) ?>"><img class="mark-card" src="./mark/icons8-стрелка-влево-30.png"></a></div>
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
            <button onclick="toggleBlock('description-container')" id="q1">Описание</button>
            <button onclick="toggleBlock('route-container')" id="q2">Маршрут</button>
            <button onclick="toggleBlock('tickets-container')" id="q3">Билеты и бронирования</button>
            <button onclick="toggleBlock('journey-container')" id="q4">В путь</button>
        </div>
    </div>
</div>
<div id="journey-container" class="block" style="display: none;">
    <div class="">
        <div>
            <div class="flexx space">
                <div class="flexx">
                    <div class="link-back"><a href="<?= Url::to(['route/index']) ?>"><img class="mark-card" src="./mark/icons8-стрелка-влево-30.png"></a></div>
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
            <button onclick="toggleBlock('description-container')" id="q1">Описание</button>
            <button onclick="toggleBlock('route-container')" id="q2">Маршрут</button>
            <button onclick="toggleBlock('tickets-container')" id="q3">Билеты и бронирования</button>
            <button onclick="toggleBlock('journey-container')" id="q4">В путь</button>
        </div>
    </div>
</div>

<div style="display: none;" class="flexx">
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
                    <div class="link-back"><a href="<?= Url::to(['route/index']) ?>"><img class="mark-card" src="./mark/icons8-стрелка-влево-30.png"></a></div>
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

        <div class="road-link flexx">
            <div class="type-road-link">
                <a href="#">
                    <img src="./mark/icons8-ходьба-50.png" class="mark-card">40 мин.
                    <span style="lgc">
                        <?php echo $model->getPrettyDistance(); ?>
                    </span>
                </a>
            </div>
            <div class="type-road-link">
                <a href="#">
                    <img src="./mark/icons8-автобус-50.png" class="mark-card">30 мин.
                    <span style="lgc">
                        <?php echo $model->getPrettyDistance(); ?>
                    </span>
                </a>
            </div>
        </div>

        <div class="flexx" id="container-switch" style="margin: 1em 0;">
            <input type="checkbox" id="switch" /><label for="switch">Toggle</label>
            <span style="margin-left: 1em;">Оптимальный маршрут</span>
        </div>

        <div class="section-link">
            <a href="#">Ср, 23.04</a>
        </div>

        <div class="list-road">
            <div class="dot flexx">
                <div class="img-prev-dot">
                    <div class="img-dot">
                        <img src="./img/dot.png">
                    </div>
                    <div class="number-dot">1</div>
                </div>
                <div class="info-dot">
                    <div class="info-text dgc">30 мин Площади</div>
                    <div class="name">Красная площадь</div>
                    <div class="address dgc">Красная площадь, Москва</div>
                </div>
            </div>
            <div class="transition flexx">
                <div class="img-transition">
                    <img src="./img/person.png">
                </div>
                <div class="info-transition dgc">
                    800 м, 10 мин.
                </div>
            </div>
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
        $points2 = [];
        foreach (Point::find()->all() as $point)
            $points2[$point->id] = $point->name;

        $form = ActiveForm::begin(['action' => 'index.php?r=route/add-point', 'method' => 'POST']); ?>

        <?= $form->field($addPointForm, 'pointId')->radioList($points2) ?>
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
                <?php if (count($points) > 0): ?>
                    <td><b>QR-код</b></td>
                    <td><b>Статус</b></td>
                <?php endif; ?>
            </tr>
            <?php if (count($points) > 0): ?>
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
            <?php else: ?>
                <?php foreach ($pointsPure as $point): ?>
                    <tr>
                        <td><?= $point->step; ?></td>
                        <td><?= $point->point->name; ?></td>
                        <td><?= $point->point->address; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
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
    <div class="map"></div>
</div>


<script>
    function buttClear(elId) {
        elId.style.color = '#747474';
        elId.style.textDecoration = 'none';
    }

    function buttOk(elId) {
        elId.style.color = 'black';
        elId.style.textDecoration = 'underline #FFCF08';
        elId.style.textDecorationThickness = '3px';
    }

    function toggleBlock(blockId) {
        var blocks = document.getElementsByClassName('block');
        for (var i = 0; i < blocks.length; i++) {
            blocks[i].style.display = 'none';
        }


        var block = document.getElementById(blockId);
        if (block) {
            block.style.display = 'block';
        }

        q1 = document.getElementById(q1);
        q2 = document.getElementById(q2);
        q3 = document.getElementById(q3);
        q4 = document.getElementById(q4);
        if (blockId == 'description-container') {
            buttClear(q2);
            buttClear(q3);
            buttClear(q4);
            buttOk(q1);
        } else if (blockId == 'route-container') {
            buttClear(q1);
            buttClear(q3);
            buttClear(q4);
            buttOk(q2);
        } else if (blockId == 'tickets-container') {
            buttClear(q1);
            buttClear(q2);
            buttClear(q4);
            buttOk(q3);
        } else{
            buttClear(q1);
            buttClear(q2);
            buttClear(q3);
            buttOk(q4);
        }
    }
</script>
