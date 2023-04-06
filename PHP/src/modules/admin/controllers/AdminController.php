<?php

namespace app\modules\admin\controllers;

use app\modules\admin\behaviors\AuthBehavior;
use yii\web\Controller;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            AuthBehavior::class
        ];
    }
}