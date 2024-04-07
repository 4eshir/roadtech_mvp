<?php

namespace app\controllers\api;

use app\models\RoutePointUser;

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
            ->where()
            ->andWhere()
            ->one();
    }
}