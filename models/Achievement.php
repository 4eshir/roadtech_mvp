<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "achievement".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property TaskAchievement[] $taskAchievements
 * @property UserAchievement[] $userAchievements
 */
class Achievement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'achievement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[TaskAchievements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAchievements()
    {
        return $this->hasMany(TaskAchievement::class, ['achievement_id' => 'id']);
    }

    /**
     * Gets query for [[UserAchievements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAchievements()
    {
        return $this->hasMany(UserAchievement::class, ['achievement_id' => 'id']);
    }
}
