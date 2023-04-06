<?php
namespace app\modules\admin\behaviors;

use app\models\User;
use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use yii\web\HttpException;

class AuthBehavior extends Behavior
{
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity['role'] !== User::ROLE_ADMIN) {
            throw new HttpException(
                403,
                'У вас нет админки XD'
            );
        }
    }
}