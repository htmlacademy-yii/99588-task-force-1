<?php

namespace frontend\models;

use yii\db\ActiveQuery;

class User extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'user';
    }

    public function rules(): array
    {
        return [
            [['created_at', 'updated_at', 'visit_at'], 'safe'],
            [['rate', 'city_id', 'profile_id'], 'integer'],
            [['email', 'name'], 'string', 'max' => 64],
            [['password'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'rate' => 'Rate',
            'city_id' => 'City ID',
            'profile_id' => 'Profile ID',
            'visit_at' => 'Visit At',
        ];
    }

    public function getAvailableNotificationTypes(): ActiveQuery
    {
        return $this->hasMany(AvailableNotificationType::className(), ['user_id' => 'id']);
    }

    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getFeedbacks(): ActiveQuery
    {
        return $this->hasMany(Feedback::className(), ['user_id' => 'id']);
    }

    public function getFiles(): ActiveQuery
    {
        return $this->hasMany(File::className(), ['user_id' => 'id']);
    }

    public function getMassages(): ActiveQuery
    {
        return $this->hasMany(Massage::className(), ['sender_id' => 'id']);
    }

    public function getMassages0(): ActiveQuery
    {
        return $this->hasMany(Massage::className(), ['recipient_id' => 'id']);
    }

    public function getNotifications(): ActiveQuery
    {
        return $this->hasMany(Notification::className(), ['user_id' => 'id']);
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    public function getResponses(): ActiveQuery
    {
        return $this->hasMany(Response::className(), ['user_id' => 'id']);
    }

    public function getEmployerTasks(): ActiveQuery
    {
        return $this->hasMany(Task::className(), ['employer_id' => 'id']);
    }

    public function getExecutorTasks(): ActiveQuery
    {
        return $this->hasMany(Task::className(), ['executor_id' => 'id']);
    }

    public function getUserCategories(): ActiveQuery
    {
        return $this->hasMany(UserCategory::className(), ['user_id' => 'id']);
    }

    public function getExecutorTasksCount(): int
    {
        return $this->getExecutorTasks()->count();
    }

    public function getFeedBacksCount(): int
    {
        return $this->getFeedBacks()->count();
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->viaTable('user_category', ['user_id' => 'id']);
    }
}
