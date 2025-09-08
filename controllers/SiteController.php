<?php

namespace app\controllers;


use app\models\search\LoginForm;
use app\models\Session;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\db\Expression;
class SiteController extends Controller
{
    public $layout = 'adminlte';

    /**
     * {@inheritdoc}
     *
     * @return array Массив с настройками поведений
     */
    public function behaviors(): array
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


    /**
     * Отображает список предстоящих сеансов
     *
     * @return string Результат рендеринга представления
     */
    public function actionIndex(): string
    {
        $sessions = Session::find()
            ->joinWith('film')
            ->where(['>=', 'start_at', new Expression('NOW()')])
            ->orderBy(['start_at' => SORT_ASC])
            ->all();

        return $this->render('index', [
            'sessions' => $sessions,
        ]);
    }
    /**
     * Авторизация пользователя
     *
     * @return string|\yii\web\Response Результат рендеринга формы авторизации или редирект
     */
    public function actionLogin(): string|\yii\web\Response
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

    /**
     * Выход пользователя из системы
     *
     * @return \yii\web\Response Редирект на главную страницу
     */
    public function actionLogout(): \yii\web\Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Обработчик ошибок приложения
     *
     * @return string Результат рендеринга страницы ошибки
     */
    public function actionError(): string
    {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null) {
            return $this->render('Ошибка', [
                'exception' => $exception,
            ]);
        }

        return $this->render('Ошибка');
    }
}