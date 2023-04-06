<?php
use app\widgets\ProductCardWidget;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <?php if (!empty($hitProducts)): ?>
        <h2>Лидеры продаж</h2>
        <div class="row">
            <?php foreach ($hitProducts as $item): ?>
                <?= ProductCardWidget::widget(['product' => $item]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($newProducts)): ?>
        <h2>Новинки</h2>
        <div class="row">
            <?php foreach ($newProducts as $item): ?>
                <?= ProductCardWidget::widget(['product' => $item]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($saleProducts)): ?>
        <h2>Распродажа</h2>
        <div class="row">
            <?php foreach ($saleProducts as $item): ?>
                <?= ProductCardWidget::widget(['product' => $item]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>