<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
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