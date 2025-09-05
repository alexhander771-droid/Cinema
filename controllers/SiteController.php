<?php

namespace app\controllers;

// TODO: убрать неиспользуемые подключения
use app\models\search\LoginForm;
use app\models\Session;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public $layout;

    /**
     * {@inheritdoc}
     * TODO: добавить возвращаемый тип функции вот так behaviors(): array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'admin'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'error', 'index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = 'adminlte'; // TODO: эту функцию целиком убрать, а 'adminlte' значение вверх в public $layout = 'adminlte'
        return parent::beforeAction($action);
    }

    //TODO: добавить phpDoc и возвращаемый тип функции
    public function actionIndex()
    {
        $query = Session::find()
            ->joinWith('film')
            ->orderBy('start_at ASC'); // TODO зачем раздельно? объединить + добавить проверку, чтобы отображались только предстоящие сеансы

        $sessions = $query->all();

        //$sessions = Session::find()
        //    ->joinWith('film')
        //    ->orderBy('start_at ASC')
        //    ->all();


        return $this->render('index', [
            'sessions' => $sessions,
        ]);
    }

    //TODO: добавить phpDoc и возвращаемый тип функции
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    //TODO: добавить phpDoc и возвращаемый тип функции
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    //TODO: добавить phpDoc и возвращаемый тип функции
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
        return $this->render('error');
    }
}