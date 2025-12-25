<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use app\models\Edition;
use app\models\EpaperCategory;

class EpaperController extends Controller
{
    /**
     * Edition Manager - List all editions for a specific epaper
     */
    public function actionIndex($epaper_id)
    {
        // Check if epaper exists
        $epaper = EpaperCategory::findOne($epaper_id);
        if (!$epaper) {
            throw new NotFoundHttpException('Epaper not found.');
        }

        // Get editions for this epaper
        $dataProvider = new ActiveDataProvider([
            'query' => Edition::find()->where(['epaper_id' => $epaper_id]),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'epaper' => $epaper,
        ]);
    }

    /**
     * View single edition
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Create new edition
     */
    public function actionCreate($epaper_id)
    {
        // Check if epaper exists
        $epaper = EpaperCategory::findOne($epaper_id);
        if (!$epaper) {
            throw new NotFoundHttpException('Epaper not found.');
        }

        $model = new Edition();
        $model->epaper_id = $epaper_id;
        
        if ($model->load(Yii::$app->request->post())) {
            // Handle file upload if you have PDF upload
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Edition created successfully.');
                return $this->redirect(['index', 'epaper_id' => $epaper_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'epaper' => $epaper,
        ]);
    }

    /**
     * Update edition
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Edition updated successfully.');
            return $this->redirect(['index', 'epaper_id' => $model->epaper_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Delete edition
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $epaper_id = $model->epaper_id;
        
        $model->delete();
        
        Yii::$app->session->setFlash('success', 'Edition deleted successfully.');
        return $this->redirect(['index', 'epaper_id' => $epaper_id]);
    }

    /**
     * Find edition model
     */
    protected function findModel($id)
    {
        if (($model = Edition::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested edition does not exist.');
    }
}
