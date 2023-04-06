<?php
namespace app\models;

use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $password;
    public $address;

    public function rules()
    {
        return [
            [['password', 'address'], 'required', 'message' => 'Обязательно'],
            ['username', 'validateUsername'],
        ];
    }

    public function validateUsername($attribute, $params)
    {
        $user = User::findByUsername($this->username);
        if (isset($user)) {
            $this->addError($attribute, 'Имя занято :(');
        }
    }

    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user['username'] = $this->username;
        $user['address'] = $this->address;
        $user['role'] = User::ROLE_SELLER;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
}