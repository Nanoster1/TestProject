<?php

namespace app\modules\admin\models;

use Yii;

class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parentId'], 'default', 'value' => null],
            [['parentId'], 'integer'],
            [['name'], 'required'],
            [['name', 'content', 'description', 'image'], 'string', 'max' => 255],
            [['parentId'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['parentId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentId' => 'ID родительской категории',
            'name' => 'Название',
            'content' => 'Краткое описание',
            'description' => 'Рили Биг дескриптион',
            'image' => 'Картинка',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['parentId' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parentId']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['categoryId' => 'id']);
    }
}