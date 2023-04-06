<?php
use app\assets\AppAsset;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title>
        <?= Html::encode($this->title) ?> | Панель управления
    </title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column min-h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => 'Панель управления',
            'brandUrl' => Url::to(['/admin/default/index']),
            'options' => [
                'class' => 'navbar-inverse',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                [
                    'label' => 'Каталог',
                    'items' => [
                        ['label' => 'Категории', 'url' => ['/admin/category/index']],
                        ['label' => 'Товары', 'url' => ['/admin/product/index']],
                    ],
                ],
                ['label' => 'Заказы', 'url' => ['/admin/order/index']],
                ['label' => 'Пользователи', 'url' => ['/admin/user/index']],
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Выйти', 'url' => ['/auth/logout']],
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'На главную', 'url' => ['/page']],
            ],
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-grow-1" role="main">
        <div class="container">
            <?= $content; ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light navbar-fixed-bottom">
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