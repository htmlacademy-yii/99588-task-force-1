<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "response".
 *
 * @property int $id
 * @property string|null $created_at
 * @property int|null $rate
 * @property string|null $description
 * @property int|null $budget
 * @property int|null $user_id
 * @property int|null $task_id
 *
 * @property Task $task
 * @property User $user
 */
class Response extends \yii\db\ActiveRecord
{
    public static function tableName() :string
    {
        return 'response';
    }

    public function rules() :array
    {
        return [
            [['created_at'], 'safe'],
            [['rate', 'budget', 'user_id', 'task_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels() :array
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

    public function getTask() :ActiveQuery
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    public function getUser() :ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
