<?php

namespace app\models\forms;

use yii\base\Model;

class RouteResultForm extends Model
{
    public $allTasks;
    public $completedTasks;

    public $allPoints;
    public $completedPoints;

    public $rewards;

    public function __construct($allTasks, $completedTasks, $allPoints, $completedPoints, $rewards)
    {
        $this->allTasks = count($allTasks);
        $this->completedTasks = count($completedTasks);
        $this->allPoints = count($allPoints);
        $this->completedPoints = count($completedPoints);
        $this->rewards = $rewards;
    }

    public function attributeLabels()
    {
        return [
            'allTasks' => 'Всего заданий',
            'completedTasks' => 'Выполнено заданий',
            'allPoints' => 'Всего точек интереса',
            'completedPoints' => 'Пройдено точек интереса',
            'rewards' => 'Награды',
        ];
    }
}