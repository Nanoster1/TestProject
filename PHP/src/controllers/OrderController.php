<?php
namespace app\controllers;

use app\models\Basket;
use app\models\Order;
use Yii;

class OrderController extends AppController
{
    public $layout = 'catalog';

    public $defaultAction = 'checkout';

    public function actionCheckout()
    {
        $order = new Order();
        if ($order->load(Yii::$app->request->post())) {
            if (!$order->validate()) {
                Yii::$app->session->setFlash(
                    'checkout-success',
                    false
                );
                Yii::$app->session->setFlash(
                    'checkout-data',
                    [
                        'name' => $order['name'],
                        'email' => $order['email'],
                        'phone' => $order['phone'],
                        'address' => $order['address'],
                        'comment' => $order['comment']
                    ]
                );
                Yii::$app->session->setFlash(
                    'checkout-errors',
                    $order->getErrors()
                );
            }
            else {
                $basket = Basket::getBasket();

                if (empty($basket[Basket::AMOUNT_KEY])) {
                    return $this->redirect('/basket/index');
                }

                $order['amount'] = $basket[Basket::AMOUNT_KEY];
                $order['status'] = Order::STATUS_NEW;

                if (!Yii::$app->user->isGuest) {
                    $user = Yii::$app->user->identity;
                    $order['userId'] = $user['id'];
                }
                $order->insert();
                $order->addItems($basket);

                $mail = Yii::$app->mailer->compose(
                    'order',
                    ['order' => $order]
                );
                $mail->setFrom('cyber.namasse@gmail.com')
                    ->setTo($order['email'])
                    ->setSubject('Заказ в магазине № ' . $order['id'])
                    ->send();

                Basket::clearBasket();
                Yii::$app->session->setFlash(
                    'checkout-success',
                    true
                );
            }
            return $this->refresh();
        }
        return $this->render('checkout', ['order' => $order]);
    }

}