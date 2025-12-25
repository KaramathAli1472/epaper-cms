<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\models\FeaturedCategory;

class FeaturedCategoryController extends Controller
{
    public function actionIndex()
    {
        // naya model (top search/add bar ke liye)
        $model = new FeaturedCategory();

        // POST aaye to save karo
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Featured category saved.');
            return $this->redirect(['index']);
        }

        // list dikhane ke liye data provider
        $dataProvider = new ActiveDataProvider([
            'query' => FeaturedCategory::find()->orderBy(['sort_order' => SORT_ASC]),
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model'        => $model,   // YAHAN se view ko $model milega
        ]);
    }

    public function actionCreate()
    {
        $model = new FeaturedCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = FeaturedCategory::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Featured category not found.');
        }
        $model->delete();
        Yii::$app->session->setFlash('success', 'Featured category deleted.');
        return $this->redirect(['index']);
    }
}
