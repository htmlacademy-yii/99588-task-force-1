<?php

namespace frontend\models;

use yii\db\ActiveQuery;

class City extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'city';
    }

    public function rules(): array
    {
        return [
            [['lat', 'long'], 'number'],
            [['city'], 'string', 'max' => 64],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }

    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Task::className(), ['city_id' => 'id']);
    }

    public function getUsers(): ActiveQuery
    {
        return $this->hasMany(User::className(), ['city_id' => 'id']);
    }
}
