<?php

namespace app\controllers\api;

use app\models\RoutePoint;
use app\models\RoutePointUser;
use app\models\TaskRouteUser;
use yii\helpers\Url;

class InternalApiController
{
    public function actionGetCheckinUserToPoint($userId, $pointId, $routeId)
    {
        $routePointUser = RoutePointUser::find()
            ->joinWith('routePoint routePoint')
            ->where(['user_id' => $userId])
            ->andWhere(['routePoint.route_id' => $routeId])
            ->andWhere(['route_point.point_id' => $pointId])
            ->one();
        return $routePointUser ?
            [
                'status' => true,
                'check' => $routePointUser->status
            ] :
            [
                'status' => false,
            ];
    }

    public function actionGetCurrentUserRouteState($userId, $routeId)
    {
        $routePointUser = RoutePointUser::find()
            ->joinWith('routePoint routePoint')
            ->where(['routePoint.route_id' => $routeId])
            ->andWhere(['user_id' => $userId])
            ->all();

        if (empty($routePointUser)) {
            return [
                'status' => false,
            ];
        }

        $data = [];

        foreach ($routePointUser as $item) {
            $data[$item->id] = $item->status;
        }

        return [
            'status' => true,
            'checkin-array' => $data,
        ];
    }

    public function actionGetQrLink($routeId, $pointId)
    {
        $routePointId = RoutePoint::find()
            ->where(['route_id' => $routeId])
            ->andWhere(['point_id' => $pointId])
            ->one();

        if (empty($routePointId)) {
            return [
                'status' => false,
            ];
        }

        return [
            'status' => true,
            'link' => Url::to(['/qr/check-point', 'rpuId' => $routePointId->id]),
        ];
    }

    public function actionGetUserCompleteTasks($userId)
    {
        $taskRouteUser = TaskRouteUser::find()
            ->where(['user_id' => $userId])
            ->andWhere(['status' => 2])->all();
        $data = [];
        foreach ($taskRouteUser as $item) {
            $data[] = ['route_id' => $item->taskRoute->route_id, 'task_id' => $item->taskRoute->task_id];
        }

        return [
            'status' => true,
            'data' => $data,
        ];
    }
}