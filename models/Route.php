<?php

namespace app\models;

use app\components\DistanceStub;
use app\models\forms\RouteResultForm;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "route".
 *
 * @property int $id
 * @property string $name
 * @property int|null $level 1 - низкий, 2 - средний, 3 - сложный
 * @property float|null $distance
 * @property int|null $type 10 - туристический, 20 - семейный с детьми, 30 - Кому слегка за 20, 40 - романтическая прогулка
 * @property int|null $created_user_id
 * @property int|null $likes
 *
 * @property Comment[] $comments
 * @property User $createdUser
 * @property RoutePoint[] $routePoints
 * @property UserRoute[] $userRoutes
 */
class Route extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['level', 'type', 'created_user_id', 'likes'], 'integer'],
            [['distance'], 'number'],
            [['name'], 'string', 'max' => 128],
            [['created_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'level' => 'Уровень',
            'distance' => 'Расстояние',
            'prettyDistance' => 'Расстояние',
            'type' => 'Тип маршрута',
            'created_user_id' => 'Создатель маршрута',
            'likes' => 'Лайки',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['to_route_id' => 'id']);
    }

    /**
     * Gets query for [[CreatedUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_user_id']);
    }

    /**
     * Gets query for [[RoutePoints]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoutePoints()
    {
        return $this->hasMany(RoutePoint::class, ['route_id' => 'id']);
    }

    /**
     * Gets query for [[UserRoutes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoutes()
    {
        return $this->hasMany(UserRoute::class, ['route_id' => 'id']);
    }

    //-------------------------

    public function getUserPoints()
    {
        return RoutePointUser::find()->joinWith('routePoint routePoint')->where(['routePoint.route_id' => $this->id])->orderBy(['routePoint.step' => SORT_ASC])->all();
    }

    public function getPoints()
    {
        return RoutePoint::find()->where(['route_id' => $this->id])->orderBy(['step' => SORT_ASC])->all();
    }

    public function getTasks()
    {
        return TaskRoute::find()->joinWith('task task')->where(['route_id' => $this->id])->orderBy(['task.reward_amount' => SORT_DESC])->all();
    }

    public function getPrettyDistance()
    {
        return round($this->distance / 1000, 1) . ' км';
    }

    public function getPrettyCreator()
    {
        return $this->createdUser->login;
    }

    public function getCompleteTasks()
    {
        return TaskRouteUser::find()->joinWith('taskRoute taskRoute')
            ->where(['user_id' => User::getCurrentUser()->id])
            ->andWhere(['taskRoute.route_id' => $this->id])
            ->andWhere(['status' => 2])->all();

    }

    public function getResult()
    {
        $tasks = TaskRouteUser::find()->joinWith('taskRoute taskRoute')
            ->where(['taskRoute.route_id' => $this->id])
            ->andWhere(['user_id' => User::getCurrentUser()->id])->all();
        $completedTasks = TaskRouteUser::find()->joinWith('taskRoute taskRoute')
            ->where(['taskRoute.route_id' => $this->id])
            ->andWhere(['user_id' => User::getCurrentUser()->id])
            ->andWhere(['status' => 2])->all();

        $points = RoutePointUser::find()->joinWith('routePoint routePoint')
            ->where(['routePoint.route_id' => $this->id])
            ->andWhere(['user_id' => User::getCurrentUser()->id])->all();
        $pointsCompleted = RoutePointUser::find()->joinWith('routePoint routePoint')
            ->where(['routePoint.route_id' => $this->id])
            ->andWhere(['user_id' => User::getCurrentUser()->id])
            ->andWhere(['status' => 2])->all();

        $taskRoutesCompleted = TaskRoute::find()->where(['IN', 'id', ArrayHelper::getColumn($completedTasks, 'id')])->all();
        $pureTasks = Task::find()->where(['IN' ,'id', ArrayHelper::getColumn($taskRoutesCompleted, 'id')])->all();

        $rewards = '';

        foreach ($pureTasks as $task) {
            $rewards .= $task->rewardTypePretty.' x'.$task->reward_amount.'<br>';
        }

        return new RouteResultForm($tasks, $completedTasks, $points, $pointsCompleted, $rewards);
    }

    public function calculateDistance()
    {
        $sumDistance = 0;
        $points = $this->getPoints();
        for ($i = 0; $i < count($points) - 1; $i++) {
            $sumDistance += DistanceStub::getDistanceBetweenPoints($points[$i]->point, $points[$i + 1]->point);
        }
        $this->distance = $sumDistance;
        $this->save();
    }

    //-------------------------

    public function beforeDelete()
    {
        $points = $this->getUserPoints();
        foreach ($points as $point) {
            $point->delete();
        }

        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }


}
