<?php
namespace app\models;

use yii\base\Model;
use Yii;

class Basket extends Model
{
    const SESSION_ID = 'basket';
    const PRODUCTS_KEY = 'products';
    const PRODUCT_COUNT_KEY = 'count';
    const PRODUCT_NAME_KEY = 'name';
    const PRODUCT_PRICE_KEY = 'price';
    const AMOUNT_KEY = 'amount';


    public static function addToBasket(int $id, int $count = 1)
    {
        if ($count < 1) {
            return;
        }
        $product = Product::getById($id);
        if (empty($product)) {
            return;
        }
        $count = $count > 10 ? 10 : $count;
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has(static::SESSION_ID)) {
            $session->set(static::SESSION_ID, []);
            $basket = [];
        }
        else {
            $basket = $session->get(static::SESSION_ID);
        }
        if (isset($basket[static::PRODUCTS_KEY][$product['id']])) { // такой товар уже есть?
            $count = $basket[static::PRODUCTS_KEY][$product['id']][static::PRODUCT_COUNT_KEY] + $count;
            if ($count > 100) {
                $count = 100;
            }
            $basket[static::PRODUCTS_KEY][$product['id']][static::PRODUCT_COUNT_KEY] = $count;
        }
        else { // такого товара еще нет
            $basket[static::PRODUCTS_KEY][$product['id']][static::PRODUCT_NAME_KEY] = $product['name'];
            $basket[static::PRODUCTS_KEY][$product['id']][static::PRODUCT_PRICE_KEY] = $product['price'];
            $basket[static::PRODUCTS_KEY][$product['id']][static::PRODUCT_COUNT_KEY] = $count;
        }
        $amount = 0.0;
        foreach ($basket[static::PRODUCTS_KEY] as $item) {
            $amount = $amount + $item[static::PRODUCT_PRICE_KEY] * $item[static::PRODUCT_COUNT_KEY];
        }
        $basket[static::AMOUNT_KEY] = $amount;
        $session->set(static::SESSION_ID, $basket);
    }

    public static function removeFromBasket(int $id)
    {
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has(static::SESSION_ID)) {
            return;
        }
        $basket = $session->get(static::SESSION_ID);
        if (!isset($basket[static::PRODUCTS_KEY][$id])) {
            return;
        }
        unset($basket[static::PRODUCTS_KEY][$id]);
        if (count($basket[static::PRODUCTS_KEY]) == 0) {
            $session->set(static::SESSION_ID, []);
            return;
        }
        $amount = 0.0;
        foreach ($basket[static::PRODUCTS_KEY] as $item) {
            $amount = $amount + $item[static::PRODUCT_PRICE_KEY] * $item[static::PRODUCT_COUNT_KEY];
        }
        $basket[static::AMOUNT_KEY] = $amount;

        $session->set(static::SESSION_ID, $basket);
    }

    public static function getBasket()
    {
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has(static::SESSION_ID)) {
            $session->set(static::SESSION_ID, []);
            return [];
        }
        else {
            return $session->get(static::SESSION_ID);
        }
    }

    public static function clearBasket()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->set(static::SESSION_ID, []);
    }

    public static function updateBasket($data)
    {
        Basket::clearBasket();
        foreach ($data[static::PRODUCT_COUNT_KEY] as $id => $count) {
            Basket::addToBasket($id, $count);
        }
    }

}