<?php

namespace backend\controllers;

use common\models\Money;
use common\models\MoneySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MoneyController implements the CRUD actions for Money model.
 */
class MoneyController extends Controller
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
     * Lists all Money models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MoneySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Money model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Money model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Money();

        if ($model->load(Yii::$app->request->post())) {

            $url = "https://v6.exchangerate-api.com/v6/1e7e800b835e602657031ee7/latest/$model->from_price";
            $data = file_get_contents($url);
            $response = json_decode($data);
            $foiz = $model->to_price;
            if ('success' === $response->result) {

                $result = round(($model->amount * $response->conversion_rates->$foiz), 10);

                return $this->render('view', [
                    'model' => $result,
                ]);
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Money model.
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
     * Deletes an existing Money model.
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
     * Finds the Money model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Money the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Money::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function Money($from, $to, $amount)
    {


        $url = "https://v6.exchangerate-api.com/v6/1e7e800b835e602657031ee7/latest/$from";
        $data = file_get_contents($url);
        $response = json_decode($data);

        if ('success' === $response->result) {

            $result = round(($amount / $response->conversion_rates->$to), 5);

            return $this->render('view', [
                'model' => $result,
            ]);
        }
    }
}
