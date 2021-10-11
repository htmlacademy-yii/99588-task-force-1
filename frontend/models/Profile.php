<?php

namespace frontend\models;

use yii\db\ActiveQuery;

class Profile extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'profile';
    }

    public function rules(): array
    {
        return [
            [['bd'], 'safe'],
            [['address'], 'string', 'max' => 128],
            [['about'], 'string', 'max' => 255],
            [['phone', 'skype'], 'string', 'max' => 64],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'bd' => 'Bd',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
        ];
    }

    public function getUsers():ActiveQuery
    {
        return $this->hasMany(User::className(), ['profiles_id' => 'id']);
    }
}
