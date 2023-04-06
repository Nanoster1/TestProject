<?php
namespace app\controllers;

use yii\helpers\Html;
use yii\web\Controller;

class AppController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}