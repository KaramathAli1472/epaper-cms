<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;
use app\models\EpaperFeaturedEdition;
use yii\web\Response;

class EpaperFeaturedEditionController extends Controller
{
    public function actionIndex()
    {
        try {
            $dataProvider = new ActiveDataProvider([
                'query' => EpaperFeaturedEdition::find()->orderBy(['sort_order' => SORT_ASC]),
                'pagination' => false,
            ]);
        } catch (InvalidConfigException $e) {
            $dataProvider = new ArrayDataProvider(['allModels' => [], 'pagination' => false]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new EpaperFeaturedEdition();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = EpaperFeaturedEdition::findOne($id);
        if (!$model) throw new NotFoundHttpException('Not found');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model = EpaperFeaturedEdition::findOne($id);
        if ($model) $model->delete();
        return $this->redirect(['index']);
    }
}
