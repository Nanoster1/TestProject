<?php
namespace app\controllers;

use app\models\Category;
use app\models\Product;
use yii\web\HttpException;

class CatalogController extends AppController
{
    public $layout = "catalog";

    public function actionIndex(): string
    {
        $root = Category::findAll(['parentId' => 0]);
        return $this->render('index', compact('root'));
    }

    public function actionCategory(int $id, int $page = 1)
    {
        $category = Category::getById($id);
        if (empty($category)) {
            throw new HttpException(
                404,
                'Запрошенная страница не найдена'
            );
        }
        list($products, $pages) = Category::getCategoryProducts($id);

        return $this->render(
            'category',
            compact('category', 'products', 'pages')
        );
    }

    public function actionProduct(int $id)
    {
        $product = Product::getById($id);
        if (empty($product)) {
            throw new HttpException(
                404,
                'Запрошенная страница не найдена'
            );
        }
        $similar = Product::find()
            ->where([
                'isHit' => 1,
                'categoryId' => $product['categoryId'],
            ])
            ->andWhere(['NOT IN', 'id', $product['id']])
            ->limit(3)
            ->all();
        return $this->render(
            'product',
            compact('product', 'similar')
        );
    }

}