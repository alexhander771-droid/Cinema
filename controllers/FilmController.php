<?php

namespace app\controllers;

use Yii;
use app\models\Film;
use app\models\FilmSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile; 


class FilmController extends Controller
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
   * @return string
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
   * @param int 
   * @return string
   * @throws NotFoundHttpException 
   */
  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * @return string|Response
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
   * @param int 
   * @return Response
   * @throws NotFoundHttpException 
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * @param int 
   * @return Film 
   * @throws NotFoundHttpException 
   */
  protected function findModel($id)
  {
    if (($model = Film::findOne(['id' => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
