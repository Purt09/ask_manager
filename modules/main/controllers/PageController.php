<?php

namespace app\modules\main\controllers;

use Yii;
use app\modules\main\models\HidePage;
use app\modules\main\models\HidePageSearch;
use yii\web\ConflictHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for HidePage model.
 *
 * Он был написна, чтобы создать страницу, у котрый каждый раз меняется url!
 */
class PageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all HidePage models.
     * @return mixed
     */
    public function actionSecret()
    {
        $searchModel = new HidePageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HidePage model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single HidePage model.
     * @param string $url
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPortfolio($url)
    {
        $model = $this->findModelbyUrl($url);
        if ($model == null)
            return $this->redirect('/main/default/portfolio');

        $model->url = md5(time());
        $model->save();


        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * Creates a new HidePage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HidePage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HidePage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HidePage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the HidePage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HidePage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HidePage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the HidePage model based on url value
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HidePage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelbyUrl($url)
    {
        if (($model = HidePage::find()->where(['url' => $url])->one()) !== null) {
            return $model;
        }
    }
}
