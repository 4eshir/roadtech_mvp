<?php

namespace app\models\forms;

use app\models\Route;
use yii\base\Model;

class QuestionnaireForm extends Model
{
    public $type;
    public $level;
    public $duration;

    public function rules()
    {
        return [
            [['type', 'level', 'duration'], 'required'],
            [['type', 'level', 'duration'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => 'Какой стиль вы предпочитаете?',
            'level' => 'Какое оптимальное количество шагов на маршруте?',
            'duration' => 'Какова желаемая длительность (в днях) маршрута?',
        ];
    }

    public function search()
    {
        $routes = Route::find()
            ->where(['type' => $this->type])
            ->andWhere(['level' => $this->level])
            ->all();

        return $routes;
    }
}