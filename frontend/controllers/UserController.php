<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\User;

class UserController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'users' => $users
        ]);
    }
}
