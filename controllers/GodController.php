<?php

namespace app\controllers;

use app\models\RoutePoint;
use app\models\RoutePointUser;
use app\models\TaskRouteUser;
use app\models\User;
use app\models\UserRoute;
use app\models\TaskRoute;
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

class GodController extends Controller
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSuccessTask($trId)
    {
        $trUser = TaskRouteUser::find()->where(['task_route_id' => $trId])->andWhere(['user_id' => User::getCurrentUser()->id])->one();
        $trUser->status = 2;
        $trUser->save();
        Yii::$app->session->setFlash('success', 'Задание засчитано успешно выполненным');

        return $this->redirect(['index']);
    }

    public function actionTakeTask($trId)
    {
        $trUser = TaskRouteUser::find()->where(['task_route_id' => $trId])->andWhere(['user_id' => User::getCurrentUser()->id])->one();
        $trUser->status = 1;
        $trUser->save();
        Yii::$app->session->setFlash('success', 'Задание засчитано взятым на выполнение');

        return $this->redirect(['index']);
    }

    public function actionFailTask($trId)
    {
        $trUser = TaskRouteUser::find()->where(['task_route_id' => $trId])->andWhere(['user_id' => User::getCurrentUser()->id])->one();
        $trUser->status = 3;
        $trUser->save();
        Yii::$app->session->setFlash('success', 'Задание засчитано проваленным');

        return $this->redirect(['index']);
    }

    public function actionLinkRoute($routeId)
    {
        $routeUser = new UserRoute();
        $routeUser->route_id = $routeId;
        $routeUser->user_id = User::getCurrentUser()->id;
        $routeUser->status = 2;
        $routeUser->save();
        Yii::$app->session->setFlash('success', 'Маршрут привязан к текущему пользователю');

        $points = RoutePoint::find()->where(['route_id' => $routeId])->all();
        foreach ($points as $point) {
            $pointUser = new RoutePointUser();
            $pointUser->route_point_id = $point->id;
            $pointUser->user_id = User::getCurrentUser()->id;
            $pointUser->status = 1;
            $pointUser->save();
        }

        $tasks = TaskRoute::find()->where(['route_id' => $routeId])->all();
        foreach ($tasks as $task) {
            $taskRouteUser = new TaskRouteUser();
            $taskRouteUser->task_route_id = $task->id;
            $taskRouteUser->user_id = User::getCurrentUser()->id;
            $taskRouteUser->status = 1;
            $taskRouteUser->save();
        }

        return $this->redirect(['index']);
    }

    public function actionEndRoute($userRouteId)
    {
        $routeUser = UserRoute::find()->where(['id' => $userRouteId])->one();
        $routeUser->status = 3;
        $routeUser->save();

        $points = RoutePointUser::find()->joinWith('routePoint routePoint')->where(['user_id' => $routeUser->user_id])->andWhere(['routePoint.route_id' => $routeUser->route_id])->all();
        foreach ($points as $point) {
            if ($point->status == 1) {
                $point->status = 3;
                $point->save();
            }
        }

        $tasks = TaskRouteUser::find()->joinWith('taskRoute taskRoute')->where(['taskRoute.route_id' => $routeUser->route_id])->andWhere(['user_id' => $routeUser->user_id])->all();
        foreach ($tasks as $task) {
            if ($task->status == 1) {
                $task->status = 3;
                $task->save();
            }
        }

        Yii::$app->session->setFlash('success', 'Маршрут завершен для текущего пользователя');

        return $this->redirect(['index']);
    }

    public function actionGenerateQr($routePointId)
    {
        $qrCode = (new QrCode(Url::to(['/qr/'])))
            ->setSize(250)
            ->setForegroundColor(255,207,8)
            ->setBackgroundColor(245,245,245);

        $rp = RoutePoint::find()->where(['id' => $routePointId])->one();
        $rp->qr_code = '/upload/qr/'.$routePointId.'.png';
        $rp->save();

        $qrCode->writeFile(Yii::$app->basePath.'/web/upload/qr/'.$routePointId.'.png');

        Yii::$app->session->setFlash('success', 'QR-код успешно выдан');

        return $this->redirect(['index']);
    }

    public function actionLinkTaskToRoute($routeId, $taskId)
    {
        $taskRoute = new TaskRoute();
        $taskRoute->route_id = $routeId;
        $taskRoute->task_id = $taskId;
        $taskRoute->save();

        //если маршрут привязан к пользователю, то создаем привязку задания
        if (UserRoute::find()->where(['user_id' => User::getCurrentUser()->id])->andWhere(['route_id' => $routeId])->one()) {
            $taskRouteUser = new TaskRouteUser();
            $taskRouteUser->task_route_id = $taskRoute->id;
            $taskRouteUser->user_id = User::getCurrentUser()->id;
            $taskRouteUser->save();
        }

        Yii::$app->session->setFlash('success', 'Задача успешно привязана');

        return $this->redirect(['index']);
    }
}
