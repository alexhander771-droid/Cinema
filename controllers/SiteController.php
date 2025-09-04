<?php

namespace app\controllers;

use Yii;
use app\models\Session;
use app\models\User;
use app\models\LoginForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
        $this->layout = 'adminlte';
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Session::find()
            ->joinWith('film')
            ->orderBy('start_at ASC');

        $sessions = $query->all();

        return $this->render('index', [
            'sessions' => $sessions,
        ]);
    }

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

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function layout()
    {
        return 'adminlte';
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
        return $this->render('error');
    }
}