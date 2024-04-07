<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\User;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

$this->registerCssFile('./css/footer.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'RUSSPASS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Маршруты', 'url' => ['/route/index']],
            ['label' => 'Мой профиль', 'url' => ['/user/profile', 'id' => User::getCurrentUser()->id]],
            ['label' => 'Пользователи', 'url' => ['/user/index']],
            ['label' => 'Социальная часть', 'url' => ['/social/index']],
            ['label' => 'God\'s panel', 'url' => ['/god/index']],
            ['label' => 'Swagger', 'url' => ['/site/swagger']],
        ]
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="row">
        <div class="contact col-md-4 col-sm-6">
            <div class="cont-text">Контакты</div>
            <div class="number">8 (800) 300-6-122</div>
            <div class="mail">press@welcome.moscow</div>
        </div>
        <div class="contact-2 col-md-4 col-sm-6">
            <div>О проекте</div>
            <div>Вход для партнеров</div>
        </div>
        <div class="icone-media-link col-md-4 col-sm-6">
        </div>
    </div>
    <div class="line"></div>
    <div class="footer2">
        <div class="block-flex">
            <div class="text-no-link">РАЗВИТИЕ ТУРИЗМА<br>И ГОСТЕПРИИМСТВА<br>МОСКВЫ</div>
            <div class="block-flex block2">
                <div>Политика конфиденциальности</div>
                <div>Политика обработки персональных данных</div>
            </div>
        </div>
    </div>
    <!--<div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div> -->
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
