<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "available_notification_type".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $notification_type
 *
 * @property User $user
 */
class AvailableNotificationType extends \yii\db\ActiveRecord
{
    public static function tableName() :string
    {
        return 'available_notification_type';
    }

    public function rules() :array
    {
        return [
            [['user_id'], 'integer'],
            [['notification_type'], 'string', 'max' => 64],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels() :array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'notification_type' => 'Notification Type',
        ];
    }

    public function getUser() :ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
