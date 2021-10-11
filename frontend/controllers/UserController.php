<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\User;

class UserController extends Controller
{
    public function actionIndex()
    {
        $users = User::find()->joinWith('categories')->joinWith('employerTasks')->all();
        var_dump($users);
        return $this->render('index', [
            'users' => $users
        ]);
    }
}
