<?php

namespace app\modules\admin\controllers;

use app\modules\admin\behaviors\AuthBehavior;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            AuthBehavior::class
        ];
    }
}