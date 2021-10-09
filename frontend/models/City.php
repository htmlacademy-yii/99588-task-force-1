<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string|null $city
 * @property float|null $lat
 * @property float|null $long
 *
 * @property Task[] $tasks
 * @property User[] $users
 */
class City extends \yii\db\ActiveRecord
{
    public static function tableName() :string
    {
        return 'city';
    }

    public function rules() :array
    {
        return [
            [['lat', 'long'], 'number'],
            [['city'], 'string', 'max' => 64],
        ];
    }

    public function attributeLabels() :array
    {
        return [
            'id' => 'ID',
            'city' => 'City',
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }

    public function getTasks() :ActiveQuery
    {
        return $this->hasMany(Task::className(), ['city_id' => 'id']);
    }

    public function getUsers() :ActiveQuery
    {
        return $this->hasMany(User::className(), ['city_id' => 'id']);
    }
}
