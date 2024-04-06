<?php

namespace app\models\forms;

class RouteResultForm
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
}