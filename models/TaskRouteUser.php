<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_route_user".
 *
 * @property int $id
 * @property int|null $task_route_id
 * @property int|null $user_id
 * @property int|null $status 1 - взята пользователем, 2 - выполнена, 3 - не выполнена
 *
 * @property TaskRoute $taskRoute
 * @property User $user
 */
class TaskRouteUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_route_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_route_id', 'user_id', 'status'], 'integer'],
            [['task_route_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaskRoute::class, 'targetAttribute' => ['task_route_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_route_id' => 'Task Route ID',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[TaskRoute]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskRoute()
    {
        return $this->hasOne(TaskRoute::class, ['id' => 'task_route_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    //----------------------------------------

    public function getTaskRewardPretty()
    {
        return $this->taskRoute->task->rewardTypePretty.' x'.$this->taskRoute->task->reward_amount;
    }
}
