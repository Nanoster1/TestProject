<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
        ];
    }

    public function login()
    {
        if (!$this->validate()) return false;
        $user = User::findByUsername($this->username);
        if (!isset($user)) return false;
        return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

}