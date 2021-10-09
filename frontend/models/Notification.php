<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property string|null $text
 * @property string|null $notification_type
 * @property int|null $user_id
 *
 * @property User $user
 */
class Notification extends \yii\db\ActiveRecord
{
    public static function tableName() :string
    {
        return 'notification';
    }

    public function rules() :array
    {
        return [
            [['user_id'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['notification_type'], 'string', 'max' => 64],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels() :array
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'notification_type' => 'Notification Type',
            'user_id' => 'User ID',
        ];
    }

    public function getUser() :ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
