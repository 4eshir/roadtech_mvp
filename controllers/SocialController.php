<?php

namespace app\controllers;

use app\models\forms\RouteCommentForm;
use app\models\Route;
use app\models\RouteComment;
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

class SocialController extends Controller
{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
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


    public function actionIndex()
    {
        return $this->render('index', [
            'routes' => Route::find()->all(),
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Route::findOne($id),
            'commentForm' => new RouteCommentForm(),
            'commentAnswerForm' => new RouteCommentForm(),
            'commentsList' => RouteComment::find()->where(['route_id' => $id])->andWhere(['answer_to' => null])->all(),
        ]);
    }

    public function actionSendComment()
    {
        $model = new RouteCommentForm();
        $entity = new RouteComment();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save($entity)) {
                return $this->redirect(['view', 'id' => $entity->route_id]);
            }
        }
    }

    public function actionLikeRoute($id)
    {
        $route = Route::findOne($id);
        $route->likes += 1;
        $route->save();

        return $this->redirect(['view', 'id' => $id]);
    }
}
