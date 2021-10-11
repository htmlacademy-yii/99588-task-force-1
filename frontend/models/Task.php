<?php

namespace frontend\models;

use yii\db\ActiveQuery;

class Task extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'task';
    }

    public function rules(): array
    {
        return [
            [['created_at', 'updated_at', 'expire'], 'safe'],
            [['category_id', 'budget', 'employer_id', 'executor_id', 'city_id'], 'integer'],
            [['lat', 'long'], 'number'],
            [['description'], 'string', 'max' => 255],
            [['name', 'status'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 128],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['employer_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'category_id' => 'Category ID',
            'description' => 'Description',
            'expire' => 'Expire',
            'name' => 'Name',
            'address' => 'Address',
            'budget' => 'Budget',
            'lat' => 'Lat',
            'long' => 'Long',
            'status' => 'Status',
            'employer_id' => 'Employer ID',
            'executor_id' => 'Executor ID',
            'city_id' => 'City ID',
        ];
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getEmployer(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'employer_id']);
    }

    public function getExecutor(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'executor_id']);
    }

    public function getFeedbacks(): ActiveQuery
    {
        return $this->hasMany(Feedback::className(), ['task_id' => 'id']);
    }

    public function getFiles(): ActiveQuery
    {
        return $this->hasMany(File::className(), ['task_id' => 'id']);
    }

    public function getResponses(): ActiveQuery
    {
        return $this->hasMany(Response::className(), ['task_id' => 'id']);
    }
}
