<?php
namespace app\models;

use yii\db\ActiveRecord;

class OrderItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'order_item';
    }

    public function getOrder()
    {
        return Order::findOne($this['orderId']);
    }
}