<?php
namespace app\widgets;

use yii\base\Widget;

class ProductCardWidget extends Widget
{
    public $product = null;

    public function run()
    {
        return $this->render('card', ['product' => $this->product]);
    }
}