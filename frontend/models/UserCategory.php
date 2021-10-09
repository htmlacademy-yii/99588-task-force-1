<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user_category".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 *
 * @property Category $category
 * @property User $user
 */
class UserCategory extends \yii\db\ActiveRecord
{
    public static function tableName() :string
    {
        return 'user_category';
    }

    public function rules() :array
    {
        return [
            [['user_id', 'category_id'], 'required'],
            [['user_id', 'category_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels() :array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
        ];
    }

    public function getCategory() :ActiveQuery
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getUser() :ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
