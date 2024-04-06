<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_achievement".
 *
 * @property int $id
 * @property int|null $task_id
 * @property int|null $achievement_id
 *
 * @property Achievement $achievement
 * @property Task $task
 */
class TaskAchievement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_achievement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'achievement_id'], 'integer'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['task_id' => 'id']],
            [['achievement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Achievement::class, 'targetAttribute' => ['achievement_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'achievement_id' => 'Achievement ID',
        ];
    }

    /**
     * Gets query for [[Achievement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAchievement()
    {
        return $this->hasOne(Achievement::class, ['id' => 'achievement_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }
}
