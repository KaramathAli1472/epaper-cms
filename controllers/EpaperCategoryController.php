<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\models\EpaperCategory;

class EpaperCategoryController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => EpaperCategory::find()->orderBy(['id' => SORT_ASC]),
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate($parent_id = null)
    {
        $model = new EpaperCategory();
        $model->parent_id = $parent_id;

        if ($model->load(Yii::$app->request->post())) {
            $model->uploadAndSaveImage();
            $model->is_published = 0; // default unpublished

            if ($model->save(false)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = EpaperCategory::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Category not found');
        }

        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * + / − publish toggle (AJAX)
     */
    public function actionTogglePublish()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $model = EpaperCategory::findOne($id);

        if (!$model) {
            return ['success' => false];
        }

        $model->is_published = $model->is_published ? 0 : 1;
        $model->save(false);

        return [
            'success' => true,
            'status'  => $model->is_published
        ];
    }

    public function actionFixName()
    {
        Yii::$app->db->createCommand("
            ALTER TABLE epaper_category 
            MODIFY COLUMN `name` VARCHAR(255) DEFAULT ''
        ")->execute();

        echo "<h3>✅ FIXED: name field default value added!</h3>";
        echo "<a href='/epaper-category/index' class='btn btn-success'>Go to Categories</a>";
        exit;
    }
}

