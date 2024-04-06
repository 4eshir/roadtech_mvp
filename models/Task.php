<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string|null $description
 * @property int|null $reward_type 1 - бонусы RUSSPASS, 2 - реальные деньги, 3 - виртуальное достижение
 * @property int|null $reward_amount
 *
 * @property TaskAchievement[] $taskAchievements
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reward_type', 'reward_amount'], 'integer'],
            [['description'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'reward_type' => 'Reward Type',
            'reward_amount' => 'Reward Amount',
        ];
    }

    /**
     * Gets query for [[TaskAchievements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAchievements()
    {
        return $this->hasMany(TaskAchievement::class, ['task_id' => 'id']);
    }

    public function getRewardTypePretty()
    {
        switch ($this->reward_type) {
            case 1:
                return 'Бонусы RUSSPASS';
            case 2:
                return 'Рубли ';
            case 3:
                return 'Виртуальное достижение';
            default:
                return 'DEFAULT';
        }
    }
}
