<?php

namespace app\controllers;

use app\models\EntryForm;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionSay(string $message)
    {
        $result = file_get_contents('http://nginx:3000/index.php?r=site%2Findex');
        return $this->render('test', [
            'message' => $result
        ]);
    }

    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load($this->request->post()) && $model->validate()) {
            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            return $this->render('entry', ['model' => $model]);
        }
    }
}