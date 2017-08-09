<?php
/**
 * Created by PhpStorm.
 * User: mint2
 * Date: 27.07.17
 * Time: 11:45
 */

namespace app\controllers;


use app\models\LoginForm;
use app\models\User;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionLoginVk($uid, $first_name, $photo)
    {
        $user = new User();

       if($user->saveFromVK($uid, $first_name, $photo))
       {
           return $this->goHome();
       }
    }

//    public function actionValid()
//    {
//        $user = User::findOne(1);
//        Yii::$app->user->login($user);
//
//        if(Yii::$app->user->isGuest)
//        {
//            echo 'guest';
//        }else{
//            echo 'authorized';
//        }
//    }

}