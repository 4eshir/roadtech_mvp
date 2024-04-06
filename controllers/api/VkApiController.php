<?php

namespace app\controllers\api;

use app\models\api\vk\VkApiHandler;
use yii\web\Controller;

class VkApiController extends Controller
{
    private VkApiHandler $handler;

    public function __construct($id, $module, VkApiHandler $handler, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->handler = $handler;
    }

    public function actionSentSteps($steps, $dist)
    {
        return json_encode(
            $this->handler->sentSteps(
                $steps,
                $dist,
                '2024-04-06',
                $this->actionAuth(VkApiHandler::APP_ID, VkApiHandler::CALLBACK_URL)
            )
        );
    }

    public function actionAuth($appId, $callbackUrl)
    {
        $codeRequest = $this->handler->getCode($appId, $callbackUrl);
        $accessToken = $this->handler->getToken(
            $appId,
            VkApiHandler::APP_SECRET_KEY,
            $callbackUrl,
            $codeRequest["code"]
        );

        return $accessToken;
    }
}
