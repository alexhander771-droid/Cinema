<?php

namespace app\controllers;

use app\models\search\SessionSearch;
use app\models\Session;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SessionController extends Controller
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
        'access' => [
          'class' => AccessControl::className(),
          'rules' => [
            [
              'allow' => true,
              'roles' => ['@'],
            ],
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
    $searchModel = new SessionSearch();
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
  public function actionCreate($model)
  {
      if ($this->request->isPost) {
          if ($model->load($this->request->post()) && $model->save()) {
              return true;
          }
      } else {
          $model->loadDefaultValues();
      }
      return false;
  }

  /**
   * @param int 
   * @return string|\Response
   * @throws NotFoundHttpException
   */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->loadAndSaveModel($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
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
   * @return Session 
   * @throws NotFoundHttpException 
   */
  protected function findModel($id)
  {
    if (($model = Session::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
