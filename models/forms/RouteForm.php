<?php

namespace app\models\forms;

use app\components\DistanceStub;
use app\models\Point;
use app\models\Route;
use app\models\RoutePoint;
use app\models\User;
use yii\base\BaseObject;
use yii\base\Model;

class RouteForm extends Model
{
    public $name;
    public $level;
    public $type;
    public $pointIds;

    public $pointList = [];

    public function __construct($config = [])
    {
        parent::__construct($config);
        $points = Point::find()->all();
        foreach ($points as $point)
            $this->pointList[$point->id] = $point->name;
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'level' => 'Уровень сложности',
            'type' => 'Тип маршрута',
            'pointIds' => 'Ключевые точки маршрута'
        ];
    }

    public function rules()
    {
        return [
            ['name', 'string', 'max' => 128],
            [['level', 'type'], 'integer'],
            ['pointIds', 'safe'],
        ];
    }

    public function save(Route $entity)
    {
        $entity->name = $this->name;
        $entity->level = $this->level;
        $entity->type = $this->type;
        $entity->created_user_id = User::getCurrentUser()->id;
        $entity->likes = 0;

        $check = $entity->save();

        $counter = 1;
        if (!empty($this->pointIds)) {
            foreach ($this->pointIds as $point) {
                $routePoint = new RoutePoint();
                $routePoint->point_id = $point;
                $routePoint->route_id = $entity->id;
                $routePoint->step = $counter;
                $routePoint->save();
                $counter++;
            }

        }

        $entity->calculateDistance();
        $entity->save();

        return $check;
    }
}