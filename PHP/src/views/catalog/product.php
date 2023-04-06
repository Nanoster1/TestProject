<?php
/*
 * Страница товара, файл views/catalog/product.php
 */

use app\widgets\ProductCardWidget;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<h1>
    <?= Html::encode($product['name']); ?>
</h1>
<div class="row">
    <div class="col-sm-5">
        <div class="product-image">
            <?=
                Html::img(
                    $product['image'],
                    ['alt' => $product['name']]
                );
            ?>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="product-info">
            <p class="product-price">
                Цена: <span>
                    <?= $product['price']; ?>
                </span> руб.
            </p>
            <form method="post" action="<?= Url::to(['basket/add']); ?>" class="add-to-basket">
                <label>Количество</label>
                <input name="count" type="text" value="1" />
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
            <p>Артикул: 1234567</p>
            <p>Наличие: На складе</p>
        </div>
    </div>
</div>
<div class="product-descr">
    <?= $product['content']; ?>
</div>