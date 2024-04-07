<?php

namespace app\controllers;

use app\components\DistanceStub;
use app\models\components\ShortestRouteComponent;
use app\models\components\ShortPointRecord;
use app\models\forms\AddPointForm;
use app\models\forms\QuestionnaireForm;
use app\models\forms\RouteForm;
use app\models\Point;
use app\models\Route;
use app\models\RoutePoint;
use app\models\RoutePointUser;
use app\models\search\SearchRoute;
use app\models\TaskRoute;
use app\models\TaskRouteUser;
use app\models\User;
use app\models\UserRoute;
use http\Exception\RuntimeException;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RouteController implements the CRUD actions for route model.
 */
class RouteController extends Controller
{
    /**
     * @inheritDoc
     */
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
     * Lists all route models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $routes = Route::find()->all();

        return $this->render('index', [
            'routes' => $routes,
        ]);
    }

    /**
     * Displays a single route model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $points = $model->getUserPoints();
        $pointsPure = $model->getPoints();
        $tasks = $model->getTasks();
        $completeTasks = $model->getCompleteTasks();
        $addPointForm = new AddPointForm();

        $result = $model->getResult();

        return $this->render('view', [
            'model' => $model,
            'points' => $points,
            'pointsPure' => $pointsPure,
            'tasks' => $tasks,
            'completeTasks' => $completeTasks,
            'result' => $result,
            'addPointForm' => $addPointForm,
        ]);
    }

    /**
     * Creates a new route model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new RouteForm();
        $entity = new Route();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save($entity)) {
                return $this->redirect(['view', 'id' => $entity->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionAddPoint()
    {
        $model = new AddPointForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                switch ($model->method) {
                    case 1:
                        $this->addPointToEnd($model->routeId, $model->pointId);
                        break;
                    case 2:
                        $this->addPointNext($model->routeId, $model->pointId);
                        break;
                    case 3:
                        $this->addPointOptimal($model->routeId, $model->pointId);
                        break;
                    default:
                        throw new RuntimeException('Неизвестный способ добавления точки');
                }
            }
        }

        $route = Route::find()->where(['id' => $model->routeId])->one();
        $route->calculateDistance();

        return $this->redirect(['view', 'id' => $model->routeId]);

    }

    private function addPointToEnd($routeId, $pointId)
    {
        $lastStep = RoutePoint::find()->where(['route_id' => $routeId])->orderBy(['step' => SORT_DESC])->one()->step;
        $newPoint = new RoutePoint();
        $newPoint->route_id = $routeId;
        $newPoint->step = $lastStep + 1;
        $newPoint->point_id = $pointId;
        $newPoint->save();

        $rpUser = new RoutePointUser();
        $rpUser->user_id = User::getCurrentUser()->id;
        $rpUser->route_point_id = $newPoint->id;
        $rpUser->status = 1;
        $rpUser->save();
    }

    private function addPointNext($routeId, $pointId)
    {
        $routePointUser = RoutePointUser::find()
            ->joinWith('routePoint routePoint')
            ->where(['routePoint.route_id' => $routeId])
            ->andWhere(['user_id' => User::getCurrentUser()->id])
            ->andWhere(['status' => 2])
            ->orderBy(['routePoint.step' => SORT_DESC])->one();

        $routePointRecount = RoutePoint::find()->where(['>', 'step', $routePointUser->routePoint->step + 1])->all();
        foreach ($routePointRecount as $point) {
            $point->step = $point->step + 1;
            $point->save();
        }

        $newPoint = new RoutePoint();
        $newPoint->route_id = $routeId;
        $newPoint->step = $routePointUser->routePoint->step + 2;
        $newPoint->point_id = $pointId;
        $newPoint->save();

        $rpUser = new RoutePointUser();
        $rpUser->user_id = User::getCurrentUser()->id;
        $rpUser->route_point_id = $newPoint->id;
        $rpUser->status = 1;
        $rpUser->save();
    }

    private function addPointOptimal($routeId, $pointId)
    {
        $minDist = 10000000000000000;
        $minPoint = null;
        $targetPoint = Point::find()->where(['id' => $pointId])->one();

        $userPoints = RoutePointUser::find()
            ->joinWith('routePoint routePoint')
            ->where(['routePoint.route_id' => $this->id])
            ->andWhere(['user_id' => User::getCurrentUser()->id])
            ->andWhere(['status' => 1])
            ->orderBy(['routePoint.step' => SORT_ASC])->all();

        $points = RoutePoint::find()
            ->where(['route_id' => $routeId])
            ->andWhere(['NOT IN', 'id', ArrayHelper::getColumn($userPoints, 'route_point_id')])->all();
        foreach ($points as $point) {
            if (DistanceStub::getDistanceBetweenPoints($point->point, $targetPoint) < $minDist) {
                $minDist = DistanceStub::getDistanceBetweenPoints($point->point, $targetPoint);
                $minPoint = $point;
            }
        }

        $changePoints = RoutePoint::find()->where(['>', 'step', $minPoint->step])->all();
        foreach ($changePoints as $changePoint) {
            $changePoint->step += 1;
            $changePoint->save();
        }

        $newPoint = new RoutePoint();
        $newPoint->route_id = $routeId;
        $newPoint->point_id = $pointId;
        $newPoint->step = $minPoint->step + 1;
        $newPoint->save();

        $newPointUser = new RoutePointUser();
        $newPointUser->user_id = User::getCurrentUser()->id;
        $newPointUser->route_point_id = $newPoint->id;
        $newPointUser->status = 1;
        $newPointUser->save();

    }

    public function actionStartRoute($routeId)
    {
        $routeUser = new UserRoute();
        $routeUser->route_id = $routeId;
        $routeUser->user_id = User::getCurrentUser()->id;
        $routeUser->status = 2;
        $routeUser->save();
        Yii::$app->session->setFlash('success', 'Вы начали прохождение маршрута');

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

        return $this->redirect(['view', 'id' => $routeId]);
    }

    public function actionEndRoute($routeId)
    {
        $routeUser = UserRoute::find()->where(['route_id' => $routeId])->andWhere(['user_id' => User::getCurrentUser()->id])->one();
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

        Yii::$app->session->setFlash('warning', 'Маршрут завершен пользователем');

        return $this->redirect(['view', 'id' => $routeId]);
    }

    public function actionQuestionnaire()
    {
        $model = new QuestionnaireForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                /*return $this->render('index', [
                    'routes' => $model->search()
                ]);*/
                $searchModel = $model->search(); // Выполним поиск

                // Перенаправляем на страницу с результатами поиска
                $url = Url::to(['route/index', 'searchData' => $searchModel]);
                return $this->redirect($url);
            }
        }

        return $this->render('questionnaire', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing route model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing route model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the route model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return route the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Route::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
