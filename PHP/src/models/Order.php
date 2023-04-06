<?php
namespace app\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    const STATUS_NEW = 'Новый';
    const STATUS_PAYED = 'Оплачен';
    const STATUS_BULD = 'Собирается';
    const STATUS_DEL = 'Передан в доставку';
    const STATUS_COM = 'Выполнен';

    public static function tableName()
    {
        return 'order';
    }

    public function getItems()
    {
        return OrderItem::findAll(['orderId' => $this['id']]);
    }

    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'address'], 'required'],
            ['email', 'email'],
            [
                'phone',
                'match',
                'pattern' => '~^\+7\s\([0-9]{3}\)\s[0-9]{3}-[0-9]{2}-[0-9]{2}$~',
                'message' => 'Номер телефона должен соответствовать шаблону +7 (495) 123-45-67'
            ],
            [['name', 'email', 'phone'], 'string', 'max' => 50],
            [['address', 'comment'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Адрес почты',
            'phone' => 'Номер телефона',
            'address' => 'Адрес доставки',
            'comment' => 'Комментарий к заказу',
        ];
    }

    public function addItems($basket)
    {
        $products = $basket['products'];
        foreach ($products as $productId => $product) {
            $item = new OrderItem();
            $item['orderId'] = $this['id'];
            $item['productId'] = $productId;
            $item['name'] = $product['name'];
            $item['price'] = $product['price'];
            $item['quantity'] = $product['count'];
            $item['cost'] = $product['price'] * $product['count'];
            $item->insert();
        }
    }

}