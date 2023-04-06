<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
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
$this->title = 'Cyber Store'
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->params['shopName'],
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ]);

        if (Yii::$app->user->isGuest) {
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => [
                    ['label' => 'Домой', 'url' => ['/page/index']],
                    ['label' => 'Войти (Но куда?)', 'url' => ['/auth/login']],
                    ['label' => 'Зарегаться', 'url' => ['/auth/register']],
                ]
            ]);
        }
        else {
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => [
                    ['label' => 'Домой', 'url' => ['/page/index']],
                    '<li class="nav-item">'
                    . Html::beginForm(['/auth/logout'])
                    . Html::submitButton(
                        'Выйти в окно (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>',
                    ['label' => 'Кабинет свой', 'url' => ['/page/cab']],
                ]
            ]);
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Корзина 🗑', 'url' => ['/basket']],
            ]
        ]);

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity['role'] === 'admin') {
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => [
                    ['label' => 'Админ панель 🙈', 'url' => ['/admin']],
                ]
            ]);
        }

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
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy;
                    <?= Yii::$app->params['shopName'] ?>
                    <?= date('Y') ?>
                </div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>