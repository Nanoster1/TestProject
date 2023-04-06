<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $userId
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $comment
 * @property float $amount
 * @property string $status
 * @property string $created
 * @property string $updated
 *
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId'], 'default', 'value' => null],
            [['userId'], 'integer'],
            [['amount'], 'number'],
            [['created', 'updated'], 'safe'],
            [['name', 'email', 'phone', 'address', 'comment', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * Возвращает имена полей формы для редактирования заказа
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'user_id' => 'User ID',
            'name' => 'Имя',
            'email' => 'Почта',
            'phone' => 'Телефон',
            'address' => 'Адрес доставки',
            'comment' => 'Комментарий',
            'amount' => 'Сумма',
            'status' => 'Статус',
            'created' => 'Дата создания',
            'updated' => 'Дата обновления',
        ];
    }

    public function getItems()
    {
        return OrderItem::findAll(['orderId' => $this['id']]);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['orderId' => 'id']);
    }
}