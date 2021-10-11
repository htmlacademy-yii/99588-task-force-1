<?php

namespace frontend\models;

use yii\db\ActiveQuery;

class Response extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'response';
    }

    public function rules(): array
    {
        return [
            [['created_at'], 'safe'],
            [['rate', 'budget', 'user_id', 'task_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'rate' => 'Rate',
            'description' => 'Description',
            'budget' => 'Budget',
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
