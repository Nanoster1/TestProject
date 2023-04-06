<?php
namespace app\models;

use yii\db\ActiveRecord;

class OrderItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * Позволяет получить заказ, в который входит этот элемент
     */
    public function getOrder()
    {
        return Order::findOne($this['orderId']);
    }
}