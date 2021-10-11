<?php

namespace frontend\models;

use yii\db\ActiveQuery;

class AvailableNotificationType extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'available_notification_type';
    }

    public function rules(): array
    {
        return [
            [['user_id'], 'integer'],
            [['notification_type'], 'string', 'max' => 64],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'notification_type' => 'Notification Type',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
