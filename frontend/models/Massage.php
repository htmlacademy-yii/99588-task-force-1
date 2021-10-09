<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "massage".
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $sender_id
 * @property int|null $recipient_id
 *
 * @property User $recipient
 * @property User $sender
 */
class Massage extends \yii\db\ActiveRecord
{
    public static function tableName() :string
    {
        return 'massage';
    }

    public function rules() :array
    {
        return [
            [['sender_id', 'recipient_id'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
            [['recipient_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['recipient_id' => 'id']],
        ];
    }

    public function attributeLabels() :array
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'sender_id' => 'Sender ID',
            'recipient_id' => 'Recipient ID',
        ];
    }

    public function getRecipient() :ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
    }

    public function getSender() :ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }
}
