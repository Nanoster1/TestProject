<?php
namespace app\models;

use yii\data\Pagination;
use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public static function getById(int $id): ?Category
    {
        return static::findOne($id);
    }

    public function getProducts()
    {
        return Product::findAll(['category_id' => $this['id']]);
    }

    public function getParent()
    {
        return $this->findOne(['id' => $this['parentId']]);
    }

    public function getChildren()
    {
        return $this->findAll(['parentId' => $this['id']]);
    }

    public static function getCategoryProducts(int $id)
    {
        $ids = static::getAllChildIds($id);
        $ids[] = $id;
        $query = Product::find()->where(['in', 'categoryId', $ids]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 10,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $products = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return [$products, $pages];
    }

    protected static function getAllChildIds(int $id)
    {
        $children = [];
        $ids = static::getChildIds($id);
        foreach ($ids as $item) {
            $children[] = $item;
            $c = static::getAllChildIds($item);
            foreach ($c as $v) {
                $children[] = $v;
            }
        }
        return $children;
    }

    protected static function getChildIds(int $id)
    {
        $children = self::findAll(['parentId' => $id]);
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child['id'];
        }
        return $ids;
    }
}