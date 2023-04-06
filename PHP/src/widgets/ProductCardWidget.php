<?php
namespace app\widgets;

use yii\base\Widget;

/**
 * Виджет для вывода дерева разделов каталога товаров
 */
class ProductCardWidget extends Widget
{
    public $product = null;

    public function run()
    {
        return $this->render('card', ['product' => $this->product]);
    }
}