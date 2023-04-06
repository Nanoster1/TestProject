<?php

namespace app\modules\admin\controllers;

class DefaultController extends AdminController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}