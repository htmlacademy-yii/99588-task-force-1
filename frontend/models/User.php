<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $name
 * @property string|null $password
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $rate
 * @property int|null $city_id
 * @property int|null $profile_id
 * @property string|null $visit_at
 *
 * @property AvailableNotificationType[] $availableNotificationTypes
 * @property City $city
 * @property Feedback[] $feedbacks
 * @property File[] $files
 * @property Massage[] $massages
 * @property Massage[] $massages0
 * @property Notification[] $notifications
 * @property Profile $profile
 * @property Response[] $responses
 * @property Task[] $tasks
 * @property Task[] $tasks0
 * @property UserCategory[] $userCategories
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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

    /**
     * Gets query for [[AvailableNotificationTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvailableNotificationTypes()
    {
        return $this->hasMany(AvailableNotificationType::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Feedbacks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Massages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMassages()
    {
        return $this->hasMany(Massage::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Massages0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMassages0()
    {
        return $this->hasMany(Massage::className(), ['recipient_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['employer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategory::className(), ['user_id' => 'id']);
    }

    public function getExecutorTasksCount()
    {
        return Task::find()->where(['executor_id' => $this->id])->count();
    }

    public function getFeedBacksCount()
    {
        return Feedback::find()->where(['user_id' => $this->id])->count();
    }

    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->viaTable('user_category', ['user_id' => 'id']);
    }
}
