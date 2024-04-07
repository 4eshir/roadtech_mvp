<?php

namespace app\models\api\vk;

use app\models\User;

class VkApiHandler
{
    const APP_ID = '123';
    const CALLBACK_URL = 'https://roadtech/api/vk/request';
    const APP_SECRET_KEY = 'b0605a16acc84fa5b5465574071224f8d84f29c1';
    const STUB_CODE = '3e2fe07cdb18c168b051db53c1141e4ecab6cd49';
    const STUB_ACCESS_TOKEN = '831c9cef7341455c5ac0f8b26bde56228c9b49a7';
    public function getCode($appId, $callbackUrl, $responseType = 'code')
    {
        return [
            'redirect_uri' => $callbackUrl,
            'code' => '3e2fe07cdb18c168b051db53c1141e4ecab6cd49',
        ];
    }

    public function getToken($clientId, $clientSecret, $redirectUri, $code)
    {
        if ($code === self::STUB_CODE) {
            return [
                'access_token' => self::STUB_ACCESS_TOKEN,
                'expires_in' => 86400,
                'user_id' => User::getCurrentUser()->id,
            ];
        }
        return [
            'success' => false,
            'errors' => 'Invalid authorization code',
        ];
    }

    public function sentSteps($steps, $distance, $date, $access_token)
    {
        if ($access_token['access_token'] === self::STUB_ACCESS_TOKEN) {
            return [
                'success' => true,
                'message' => 'Steps updated successfully',
            ];
        }
        return [
            'success' => true,
            'error' => 'Invalid access token',
        ];
    }
}