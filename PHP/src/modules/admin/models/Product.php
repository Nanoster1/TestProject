<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $categoryId
 * @property string $name
 * @property string|null $content
 * @property float $price
 * @property string|null $description
 * @property string|null $image
 * @property bool $isHit
 * @property bool $isNew
 * @property bool $isSale
 *
 * @property Category $category
 * @property OrderItem[] $orderItems
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoryId', 'name'], 'required'],
            [['categoryId'], 'default', 'value' => null],
            [['categoryId'], 'integer'],
            [['price'], 'number'],
            [['isHit', 'isNew', 'isSale'], 'boolean'],
            [['name', 'content', 'description', 'image'], 'string', 'max' => 255],
            [['categoryId'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['categoryId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categoryId' => 'ID категории',
            'name' => 'Название',
            'content' => 'Краткое опимание',
            'price' => 'Цена',
            'description' => 'Биг Описание',
            'image' => 'Картинка',
            'isHit' => 'Хит продаж',
            'isNew' => 'Новинка',
            'isSale' => 'По скидке',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'categoryId']);
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::class, ['productId' => 'id']);
    }
}