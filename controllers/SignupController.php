<?php
/**
 * Created by PhpStorm.
 * User: mint2
 * Date: 27.07.17
 * Time: 16:52
 */

namespace app\controllers;
use app\models\SignupForm;
use Yii;
use yii\web\Controller;

class SignupController extends Controller
{
    public function actionIndex()
    {
        $model = new SignupForm();
//        var_dump(Yii::$app->request->post());
        if(Yii::$app->request->post())
        {
            $model->load(Yii::$app->request->post());

            if($model->signup())
            {
                return $this->redirect(['auth/login']);
            }
        }
        return $this->render('register', [
        'model' => $model
        ]);
    }
}