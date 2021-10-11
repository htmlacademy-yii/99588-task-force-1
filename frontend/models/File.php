<?php

namespace frontend\models;

use yii\db\ActiveQuery;

class File extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'file';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'task_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
        ];
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
