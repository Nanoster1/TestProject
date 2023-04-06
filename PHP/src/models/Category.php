<?php
namespace app\models;

use yii\data\Pagination;
use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    /**
     * Возвращает имя таблицы БД
     */
    public static function tableName()
    {
        return 'category';
    }

    public static function getById(int $id): ?Category
    {
        return static::findOne($id);
    }

    /**
     * Возвращает товары категории
     */
    public function getProducts()
    {
        // связь таблицы БД `category` с таблицей `product`
        return Product::findAll(['category_id' => $this['id']]);
    }

    /**
     * Возвращает родительскую категорию
     */
    public function getParent()
    {
        // связь таблицы БД `category` с таблицей `category`
        return $this->findOne(['id' => $this['parentId']]);
    }

    /**
     * Возвращает дочерние категории
     */
    public function getChildren()
    {
        // связь таблицы БД `category` с таблицей `category`
        return $this->findAll(['parentId' => $this['id']]);
    }

    /**
     * Возвращает массив товаров в категории с идентификатором $id и во
     * всех ее потомках, т.е. в дочерних, дочерних-дочерних и так далее
     */
    public static function getCategoryProducts(int $id)
    {
        // получаем массив идентификаторов всех потомков категории
        $ids = static::getAllChildIds($id);
        $ids[] = $id;
        // для постаничной навигации получаем только часть товаров
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

    /**
     * Возвращает массив идентификаторов всех потомков категории $id,
     * т.е. дочерние, дочерние дочерних и так далее
     */
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

    /**
     * Возвращает массив идентификаторов дочерних категорий (прямых
     * потомков) категории с уникальным идентификатором $id
     */
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