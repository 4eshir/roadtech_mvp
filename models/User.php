<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property int|null $russpass_balance
 * @property int|null $money_balance
 * @property int|null $status 10 - обычный, 20 - привилегии 1 уровня, 30 - привилегии 2 уровня
 * @property int|null $auth
 *
 * @property Route[] $routes
 * @property UserAchievement[] $userAchievements
 * @property UserRoute[] $userRoutes
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
            [['login'], 'required'],
            [['russpass_balance', 'money_balance', 'status', 'auth'], 'integer'],
            [['login'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'russpass_balance' => 'Баланс RUSSPASS',
            'money_balance' => 'Баланс в ₽',
            'status' => 'Статус пользователя',
        ];
    }

    /**
     * Gets query for [[Routes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoutes()
    {
        return $this->hasMany(Route::class, ['created_user_id' => 'id']);
    }

    /**
     * Gets query for [[UserAchievements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAchievements()
    {
        return $this->hasMany(UserAchievement::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserRoutes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoutes()
    {
        return $this->hasMany(UserRoute::class, ['user_id' => 'id']);
    }

    public static function getCurrentUser()
    {
        return User::find()->where(['auth' => 1])->one();
    }
}
