<?php

namespace app\controllers\api;

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

class VkApiController extends Controller
{
    public function actionConvertDistanceToSteps($distance)
    {

    }

    public function actionSentSteps($steps)
    {

    }
}
