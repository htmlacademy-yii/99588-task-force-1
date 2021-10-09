<?php

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Task;

class TaskController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->all();
        return $this->render('index', [
            'tasks' => $tasks
        ]);
    }
}
