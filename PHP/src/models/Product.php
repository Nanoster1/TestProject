<?php
namespace app\models;

use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    /**
     * Возвращает имя таблицы БД
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * Возвращает родительскую категорию
     */
    public function getCategory()
    {
        // связь таблицы БД `product` с таблицей `category`
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public static function getById(int $id): ?Product
    {
        return static::findOne($id);
    }
}