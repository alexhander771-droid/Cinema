<?php

namespace app\controllers;

use app\models\Film;
use app\models\search\FilmSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\web\Controller;

class FilmController extends Controller
{
    /**
     * {@inheritDoc}
     *
     * @return array<string, mixed> Массив конфигураций поведений
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Отображает список фильмов с возможностью поиска
     *
     * @return string Результат рендеринга страницы
     */
    public function actionIndex(): string
    {
        $searchModel = new FilmSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Отображает детальную информацию о фильме
     *
     * @param int $id ID фильма
     * @return string Результат рендеринга страницы
     * @throws NotFoundHttpException Если фильм не найден
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Находит модель фильма по ID
     *
     * @param int $id ID фильма
     * @return Film Найденная модель фильма
     * @throws NotFoundHttpException Если фильм не найден
     */
    protected function findModel(int $id): Film
    {
        if (($model = Film::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Создание нового фильма
     *
     * @return string|Response Результат рендеринга формы или редирект
     */
    public function actionCreate()
    {
        $model = new Film();
        $model->scenario = 'create';

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Обновление информации о фильме
     *
     * @param int $id ID фильма
     * @return string|Response Результат рендеринга формы или редирект
     * @throws NotFoundHttpException Если фильм не найден
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Удаление фильма
     *
     * @param int $id ID фильма
     * @return Response Редирект на страницу списка фильмов
     * @throws NotFoundHttpException Если фильм не найден
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}