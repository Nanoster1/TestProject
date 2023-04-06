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

    /**
     * Метод возвращает имя таблицы БД
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * Позволяет получить все товары этого заказа
     */
    public function getItems()
    {
        return OrderItem::findAll(['orderId' => $this['id']]);
    }

    /**
     * Правила валидации атрибутов класса при сохранении
     */
    public function rules()
    {
        return [
            // эти четыре поля обязательны для заполнения
            [['name', 'email', 'phone', 'address'], 'required'],
            // поле email должно быть корректным адресом почты
            ['email', 'email'],
            // поле phone должно совпадать с шаблоном +7 (495) 123-45-67
            [
                'phone',
                'match',
                'pattern' => '~^\+7\s\([0-9]{3}\)\s[0-9]{3}-[0-9]{2}-[0-9]{2}$~',
                'message' => 'Номер телефона должен соответствовать шаблону +7 (495) 123-45-67'
            ],
            // эти три строки должны быть не более 50 символов
            [['name', 'email', 'phone'], 'string', 'max' => 50],
            // эти две строки должны быть не более 255 символов
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

    /**
     * Добавляет записи в таблицу БД `order_item`
     */
    public function addItems($basket)
    {
        // получаем товары в корзине
        $products = $basket['products'];
        // добавляем товары по одному
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