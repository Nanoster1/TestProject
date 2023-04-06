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
        /*
         * Если пришли post-данные, загружаем их в модель...
         */
        if ($order->load(Yii::$app->request->post())) {
            // ...и проверяем эти данные
            if (!$order->validate()) {
                // данные не прошли валидацию, отмечаем этот факт
                Yii::$app->session->setFlash(
                    'checkout-success',
                    false
                );
                // сохраняем в сессии введенные пользователем данные
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
                // сохраняем заказ в базу данных
                $order->insert();
                $order->addItems($basket);

                // отправляем письмо покупателю
                $mail = Yii::$app->mailer->compose(
                    'order',
                    ['order' => $order]
                );
                $mail->setFrom('cyber.namasse@gmail.com')
                    ->setTo($order['email'])
                    ->setSubject('Заказ в магазине № ' . $order['id'])
                    ->send();

                // очищаем содержимое корзины
                Basket::clearBasket();
                // данные прошли валидацию, заказ успешно сохранен
                Yii::$app->session->setFlash(
                    'checkout-success',
                    true
                );
            }
            // выполняем редирект, чтобы избежать повторной отправки формы
            return $this->refresh();
        }
        return $this->render('checkout', ['order' => $order]);
    }

}