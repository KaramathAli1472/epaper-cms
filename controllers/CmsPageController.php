<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use app\models\CmsPage;

class CmsPageController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CmsPage::find()->orderBy(['id' => SORT_ASC]),
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,  // sirf ye pass karo
        ]);
    }

    public function actionCreate()
    {
        $model = new CmsPage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Page created.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = CmsPage::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Page not found.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Page updated.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = CmsPage::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Page not found.');
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Page deleted.');
        return $this->redirect(['index']);
    }
}
