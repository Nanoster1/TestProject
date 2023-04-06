<?php
namespace app\controllers;

use app\models\Product;
use app\modules\admin\models\Order;
use yii\data\ActiveDataProvider;

class PageController extends AppController
{
    public $layout = "catalog";

    /*
     * Главная страница сайта
     */
    public function actionIndex()
    {
        $hitProducts = Product::find()->where(['isHit' => true])->limit(3)->all();
        $newProducts = Product::find()->where(['isNew' => true])->limit(3)->all();
        $saleProducts = Product::find()->where(['isSale' => true])->limit(3)->all();

        return $this->render(
            'index',
            compact('hitProducts', 'newProducts', 'saleProducts')
        );
    }

    public function actionCab()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find(),
        ]);

        return $this->render('cab', [
            'dataProvider' => $dataProvider,
        ]);
    }
}