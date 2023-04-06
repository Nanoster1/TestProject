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

        /*
         * Данные должны приходить методом POST; если это не
         * так — просто показываем корзину
         */
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

        // добавляем товар в корзину и перенаправляем покупателя
        // на страницу корзины
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
        /*
         * Данные должны приходить методом POST; если это не
         * так — просто показываем корзину
         */
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