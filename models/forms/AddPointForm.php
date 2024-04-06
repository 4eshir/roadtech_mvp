<?php

namespace app\models\forms;

use yii\base\Model;

class AddPointForm extends Model
{
    public $pointId;
    public $routeId;
    public $method;

    public function rules()
    {
        return [
            [['routeId', 'method'], 'required'],
            [['routeId', 'method'], 'integer'],
            ['pointId', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'pointId' => 'Точка',
            'routeId' => 'Маршрут',
            'method' => 'Метод добавления',
        ];
    }

    public function save()
    {

    }
}