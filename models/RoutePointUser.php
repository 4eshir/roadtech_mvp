<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "route_point_user".
 *
 * @property int $id
 * @property int|null $route_point_id
 * @property int|null $user_id
 * @property int|null $status 1 - не пройдена, 2 - пройдена, 3 - пропущена
 *
 * @property RoutePoint $routePoint
 * @property User $user
 */
class RoutePointUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'route_point_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['route_point_id', 'user_id', 'status'], 'integer'],
            [['route_point_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoutePoint::class, 'targetAttribute' => ['route_point_id' => 'id']],
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
            'route_point_id' => 'Route Point ID',
            'user_id' => 'User ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[RoutePoint]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoutePoint()
    {
        return $this->hasOne(RoutePoint::class, ['id' => 'route_point_id']);
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

    //-----------------------

    public function getStatusPretty()
    {
        switch ($this->status) {
            case 1:
                return 'Не пройдена';
            case 2:
                return 'Пройдена';
            case 3:
                return 'Пропущена';
            default:
                return 'DEFAULT_STATUS';
        }
    }
}
