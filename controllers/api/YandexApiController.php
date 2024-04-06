<?php

namespace app\controllers\api;

use app\models\api\vk\VkApiHandler;
use app\models\api\yandex\YandexApiHandler;
use yii\web\Controller;

class YandexApiController extends Controller
{
    private YandexApiHandler $handler;

    public function __construct($id, $module, YandexApiHandler $handler, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->handler = $handler;
    }

    public function actionGetTaskFromArea($point, $area)
    {
        return json_encode(
            $this->handler->getTask($point, $area,
                $this->actionAuth(YandexApiHandler::CLIENT_ID, YandexApiHandler::REDIRECT_URI)
            )
        );
    }

    public function actionSubmitTask($pointId)
    {
        return json_encode(
            $this->handler->submitTask($pointId,
                $this->actionAuth(YandexApiHandler::CLIENT_ID, YandexApiHandler::REDIRECT_URI)
            )
        );
    }

    public function actionAuth($appId, $callbackUrl)
    {
        $codeRequest = $this->handler->getAuthUrl($appId, $callbackUrl);
        $accessToken = $this->handler->getAccessToken(
            $appId,
            YandexApiHandler::CLIENT_SECRET,
            $codeRequest["code"]
        );

        return $accessToken;
    }
}
