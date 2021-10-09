<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property string|null $address
 * @property string|null $bd
 * @property string|null $about
 * @property string|null $phone
 * @property string|null $skype
 *
 * @property User[] $users
 */
class Profile extends \yii\db\ActiveRecord
{
    public static function tableName() :string
    {
        return 'profile';
    }

    public function rules() :array
    {
        return [
            [['bd'], 'safe'],
            [['address'], 'string', 'max' => 128],
            [['about'], 'string', 'max' => 255],
            [['phone', 'skype'], 'string', 'max' => 64],
        ];
    }

    public function attributeLabels() :array
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
