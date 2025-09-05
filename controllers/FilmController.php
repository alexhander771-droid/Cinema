<?php

namespace app\controllers;

use app\models\Film;
use app\models\search\FilmSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


class FilmController extends Controller
{
    /**
     * @inheritDoc
     * TODO: добавить возвращаемый тип функции
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(), //TODO заменить className() на class
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * @return string
     * TODO: добавить возвращаемый тип функции
     */
    public function actionIndex()
    {
        $searchModel = new FilmSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int //TODO добавить название переменной
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id) // TODO: добавить возвращаемый тип функции
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param int TODO: добавить название переменной
     * @return Film
     * @throws NotFoundHttpException
     * TODO: добавить возвращаемый тип функции
     */
    protected function findModel($id)
    {
        if (($model = Film::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string|Response
     * TODO: добавить возвращаемый тип функции и функцию переделать так же как в SessionController
     */
    public function actionCreate()
    {
        $model = new Film();
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int
     * @return string|Response
     * @throws NotFoundHttpException
     * TODO: добавить возвращаемый тип функции и функцию переделать так же как в SessionController
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int TODO: добавить название переменной
     * @return Response
     * @throws NotFoundHttpException
     * TODO: добавить возвращаемый тип функции
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
