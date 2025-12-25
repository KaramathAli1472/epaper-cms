<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\base\InvalidConfigException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\EpaperPageCategory;

// ✅ CHANGE THIS LINE: EpaperPageCategoryController se PageCategoryController
class PageCategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        try {
            $dataProvider = new ActiveDataProvider([
                'query' => EpaperPageCategory::find()->orderBy(['sort_order' => SORT_ASC]),
                'pagination' => ['pageSize' => 20],
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
        $model = new EpaperPageCategory();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Page Category created successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = EpaperPageCategory::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Page Category not found.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Page Category updated successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = EpaperPageCategory::findOne($id);
        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Page Category deleted successfully.');
        }
        return $this->redirect(['index']);
    }
}