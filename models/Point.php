<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "point".
 *
 * @property int $id
 * @property string|null $address
 * @property float|null $geo_x
 * @property float|null $geo_y
 * @property int|null $type 10 - Еда, 20 - Жилье, 30 - Достопримечательность, 40 - Интересные точки
 *
 * @property RoutePoint[] $routePoints
 */
class Point extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'point';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['geo_x', 'geo_y'], 'number'],
            [['type'], 'integer'],
            [['address'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'geo_x' => 'Geo X',
            'geo_y' => 'Geo Y',
            'type' => 'Type',
        ];
    }

    /**
     * Gets query for [[RoutePoints]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoutePoints()
    {
        return $this->hasMany(RoutePoint::class, ['point_id' => 'id']);
    }
}
