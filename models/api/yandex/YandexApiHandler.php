<?php

namespace app\models\api\yandex;

use app\models\Task;
use app\models\User;

class YandexApiHandler
{
    const CLIENT_ID = '123';
    const CLIENT_SECRET = 'c0f0814866b2449dc8b8f53407c18f95fdfab56b';
    const REDIRECT_URI = 'http://roadtech/vk/yandex/request';
    const STUB_CODE = '3e2fe07cdb18c168b051db53c1141e4ecab6cd49';
    const STUB_ACCESS_TOKEN = '831c9cef7341455c5ac0f8b26bde56228c9b49a7';

    const STUB_POINT_ID = '2';
    const STUB_LATITUDE = '45.5674';
    const STUB_LONGITUDE = '44.6143';

    public function getAuthUrl($clientId, $redirectUri)
    {
        if ($clientId === static::CLIENT_ID) {
            return [
                'code' => self::STUB_CODE,
                'redirect_uri' => $redirectUri,
            ];
        }
        return [
            'success' => false,
            'error' => 'Invalid Client ID',
        ];
    }

    public function getAccessToken($clientId, $clientSecret, $code)
    {
        if ($clientId === static::CLIENT_ID
            && $clientSecret === static::CLIENT_SECRET
            && $code === static::STUB_CODE) {
            return [
                'access_token' => self::STUB_ACCESS_TOKEN,
                'expires_in' => 86400,
                'user_id' => User::getCurrentUser()->id,
            ];
        }
        return [
            'success' => false,
            'error' => 'Invalid authorization code',
        ];
    }

    public function getTask($point, $area, $access_token)
    {
        if ($access_token['access_token'] === self::STUB_ACCESS_TOKEN) {
            return [
                'point_id' => self::STUB_POINT_ID,
                'user_id' => User::getCurrentUser()->id,
                'location' => [
                    'latitude' => self::STUB_LATITUDE,
                    'longitude' => self::STUB_LONGITUDE,
                ],
                'updated_info' => [
                    'description' => 'Lorem ipsum',
                    'category' => 'Architectural monuments',
                ],
                'autogenerate_task_url' => 'https://roadtech.yandex.ru/autogenerate/task-'.self::STUB_POINT_ID,
            ];
        }
        return [
            'success' => false,
            'errors' => 'Invalid access token',
        ];
    }

    public function submitTask($pointId, $access_token)
    {
        if ($pointId === static::STUB_POINT_ID && $access_token['access_token'] === static::STUB_ACCESS_TOKEN) {
            return [
                'status' => 'success',
                'point_id' => $pointId,
                'message' => 'Location information updated successfully',
                'reward_type' => 'RUB',
                'reward_amount' => '100',
            ];
        }
        return [
            'success' => false,
            'errors' => 'Invalid access token or pointId',
        ];
    }

}