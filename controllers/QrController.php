<?php

namespace app\controllers;

use app\models\RoutePoint;
use app\models\RoutePointUser;
use app\models\TaskRouteUser;
use app\models\User;
use app\models\UserRoute;
use Da\QrCode\Action\QrCodeAction;
use Da\QrCode\QrCode;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class QrController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionCheckPoint($rpuId)
    {
        $routePoint = RoutePointUser::find()->where(['id' => $rpuId])->one();
        $routePoint->status = 2;
        $routePoint->save();

        return $this->redirect(['/route/view', 'id' => $routePoint->routePoint->route_id]);
    }
}
