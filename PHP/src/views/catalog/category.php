<?php
/*
 * Страница раздела каталога, файл views/catalog/category.php
 */

use app\widgets\ProductCardWidget;
use yii\helpers\Html;
use yii\widgets\LinkPager;

?>


<?php if (!empty($products)): ?>
    <h2>
        <?= Html::encode($category['name']); ?>
    </h2>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <?= ProductCardWidget::widget(['product' => $product]) ?>
        <?php endforeach; ?>
    </div>
    <?= LinkPager::widget(['pagination' => $pages]); /* постраничная навигация */?>
<?php else: ?>
    <p>Нет товаров в этой категории.</p>
<?php endif; ?>