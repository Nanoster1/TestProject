<?php
namespace app\controllers;

use app\models\Basket;
use Yii;

class BasketController extends AppController
{
    public function actionIndex()
    {
        $basket = Basket::getBasket();
        return $this->render('index', ['basket' => $basket]);
    }

    public function actionAdd()
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['basket/index']);
        }

        $data = Yii::$app->request->post();
        if (!isset($data['id'])) {
            return $this->redirect(['basket/index']);
        }
        if (!isset($data['count'])) {
            $data['count'] = 1;
        }

        Basket::addToBasket($data['id'], $data['count']);

        return $this->redirect(['basket/index']);
    }

    public function actionRemove(int $id)
    {
        Basket::removeFromBasket($id);
        return $this->redirect(['basket/index']);
    }

    public function actionClear()
    {
        Basket::clearBasket();
        return $this->redirect(['basket/index']);
    }

    public function actionUpdate()
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['basket/index']);
        }

        $data = Yii::$app->request->post();
        if (!isset($data['count'])) {
            return $this->redirect(['basket/index']);
        }
        if (!is_array($data['count'])) {
            return $this->redirect(['basket/index']);
        }

        Basket::updateBasket($data);

        return $this->redirect(['basket/index']);
    }
}