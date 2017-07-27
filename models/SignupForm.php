<?php
/**
 * Created by PhpStorm.
 * User: mint2
 * Date: 27.07.17
 * Time: 16:56
 */

namespace app\models;


use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repeat_password;

    public function rules()
    {
        return [
            [['username','email','password','repeat_password'],'required'],
            [['username'], 'string', 'min'=> 4, 'max'=> 255],
            [['email'], 'unique', 'targetClass'=>'app\models\User', 'targetAttribute'=>'email', 'message'=>"This email has been already token."],
            [['email'], 'email'],
            [['email'], 'trim'],
            ['email', 'string', 'max' => 255],
            ['repeat_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match."],

            ];
    }
    public function signup()
    {
        if($this->validate())
        {
            $user = new User();

            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);

            return $user->create();
        }
        return null;

    }


}