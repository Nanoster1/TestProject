<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="col-sm-4">
    <div class="product-wrapper text-center">
        <?=
            Html::img(
                $product['image'],
                ['alt' => $product['name'], 'class' => 'img-responsive']
            );
        ?>
        <h2>
            <?= $product['price']; ?> руб.
        </h2>
        <p>
            <a href="<?= Url::to(['catalog/product', 'id' => $product['id']]); ?>">
                <?= Html::encode($product['name']); ?>
            </a>
        </p>
        <form method="post" action="<?= Url::to(['basket/add']); ?>">
            <input type="hidden" name="id" value="<?= $product['id']; ?>">
            <?=
                Html::hiddenInput(
                    Yii::$app->request->csrfParam,
                    Yii::$app->request->csrfToken
                );
            ?>
            <button type="submit" class="btn btn-warning">
                <i class="fa fa-shopping-cart"></i>
                Добавить в корзину
            </button>
        </form>
        <?php
        if ($product['isNew']) {
            echo 'Новинка';

        }
        if ($product['isSale']) {
            echo '<br/> Скидка';
        }
        ?>
    </div>
</div>