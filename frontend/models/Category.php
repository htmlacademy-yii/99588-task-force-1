<?php

namespace frontend\models;

use yii\db\ActiveQuery;

class Category extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'category';
    }

    public function rules(): array
    {
        return [
            [['name', 'icon'], 'string', 'max' => 64],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon',
        ];
    }

    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Task::className(), ['category_id' => 'id']);
    }

    public function getUserCategories(): ActiveQuery
    {
        return $this->hasMany(UserCategory::className(), ['category_id' => 'id']);
    }
}
