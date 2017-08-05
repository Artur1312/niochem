<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $isAdmin
 * @property string $photo
 *
 * @property Comment[] $comments
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isAdmin'], 'integer'],
            [['username', 'email', 'password', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
            'photo' => 'Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }


    public static function findIdentity($id)
    {
        return User::findOne($id);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }


    public function getId()
    {
       return $this->id;
    }


    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }


    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public static function findByUsername($username)
    {
        return User::find()->where(['username'=>$username])->one();
    }

    public static function findByEmail($email)
    {
        return User::find()->where(['email'=>$email])->one();
    }

//    public function ValidatePassword($password)
//    {
//        return ($this->password == $password) ? true : false;
//    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return int
     */
    public function saveFromVK($uid, $first_name, $photo)
    {
        $user = User::findOne($uid);

        if($user) {
            return Yii::$app->user->login($user);
        }


        $this->id = $uid;
        $this->username = $first_name;
        $this->photo = $photo;
        $this->create();

        return Yii::$app->user->login($this);
    }


//save-create method for signup form, where your data save to database.

    public function create()
    {
        return $this->save(false);
    }

    public function getImage()
    {
//         if($this->image)
//         {
//            return '/uploads/' . $this->image;
//         }
//         return '/no-image.png';

        return $this->photo;
    }


}
