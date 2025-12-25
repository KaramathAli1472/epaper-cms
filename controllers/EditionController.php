<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\Edition;
use app\models\EpaperCategory;

class EditionController extends Controller
{
    /**
     * Edition list – simple (no search model)
     */
    public function actionIndex($epaper_id = null)
    {
        if ($epaper_id) {
            $epaper = EpaperCategory::findOne($epaper_id);
            if (!$epaper) {
                throw new NotFoundHttpException('Epaper not found.');
            }

            $query = Edition::find()
                ->where(['epaper_id' => $epaper_id])
                ->orderBy(['date' => SORT_DESC]);

            $pageTitle = 'Edition Manager - ' . $epaper->title;
        } else {
            $query     = Edition::find()->orderBy(['date' => SORT_DESC]);
            $epaper    = null;
            $pageTitle = 'All Editions';
        }

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => 15],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'epaper'       => $epaper,
            'pageTitle'    => $pageTitle,
        ]);
    }

    /**
     * Create new edition – string status
     */
    public function actionCreate($epaper_id)
    {
        $epaper = EpaperCategory::findOne($epaper_id);
        if (!$epaper) {
            throw new NotFoundHttpException('Epaper not found.');
        }

        $model = new Edition();
        $model->epaper_id = $epaper_id;
        $model->status    = Edition::STATUS_DRAFT;
        $model->date      = date('Y-m-d');
        $model->code      = $model->generateUniqueCode();

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if (isset($post['btn-schedule'])) {
                $model->status = Edition::STATUS_SCHEDULED;
            } elseif (isset($post['btn-private'])) {
                $model->status = Edition::STATUS_PRIVATE;
            } elseif (isset($post['btn-publish'])) {
                $model->status = Edition::STATUS_PUBLISHED;
            } else {
                $model->status = Edition::STATUS_DRAFT;
            }

            if (empty($model->code)) {
                $model->code = $model->generateUniqueCode();
            }

            if ($model->save()) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['success' => true];
                }

                Yii::$app->session->setFlash(
                    'success',
                    'Edition created successfully! Status: ' . $model->getStatusText()
                );
                return $this->redirect(['index', 'epaper_id' => $epaper_id]);
            }

            Yii::$app->session->setFlash('error', 'Error saving edition.');
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form', [
                'model'  => $model,
                'epaper' => $epaper,
            ]);
        }

        return $this->render('create', [
            'model'  => $model,
            'epaper' => $epaper,
        ]);
    }

    /**
     * Update edition – string status
     */
    public function actionUpdate($id)
    {
        $model  = $this->findModel($id);
        $epaper = $model->epaper;

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if (isset($post['btn-schedule'])) {
                $model->status = Edition::STATUS_SCHEDULED;
            } elseif (isset($post['btn-private'])) {
                $model->status = Edition::STATUS_PRIVATE;
            } elseif (isset($post['btn-publish'])) {
                $model->status = Edition::STATUS_PUBLISHED;
            }

            if (empty($model->code)) {
                $model->code = $model->generateUniqueCode();
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Edition updated successfully.');
                return $this->redirect(['index', 'epaper_id' => $model->epaper_id]);
            }

            Yii::$app->session->setFlash('error', 'Error updating edition.');
        }

        return $this->render('update', [
            'model'  => $model,
            'epaper' => $epaper,
        ]);
    }

    /**
     * Change edition status
     */
    public function actionChangeStatus($id, $status)
    {
        $model = $this->findModel($id);
        $allowedStatuses = ['draft', 'scheduled', 'private', 'published'];

        if (in_array($status, $allowedStatuses, true)) {
            $model->status = $status;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Status changed to ' . $status);
            }
        }

        return $this->redirect(['index', 'epaper_id' => $model->epaper_id]);
    }

    /**
     * Delete edition
     */
    public function actionDelete($id)
    {
        $model     = $this->findModel($id);
        $epaper_id = $model->epaper_id;
        $model->delete();

        Yii::$app->session->setFlash('success', 'Edition deleted successfully.');
        return $this->redirect(['index', 'epaper_id' => $epaper_id]);
    }

    /**
     * View edition
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Find Edition model
     */
    protected function findModel($id)
    {
        if (($model = Edition::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Edition not found.');
    }

    /* Debug helpers (optional) */

    public function actionCheckStatus()
    {
        echo "<h3>Checking Database Status</h3>";

        $editions = Edition::find()->all();
        foreach ($editions as $edition) {
            echo "ID: {$edition->id}, Title: {$edition->title}, Status: {$edition->status}, "
               . "Code: {$edition->code}, Type: " . gettype($edition->status) . "<br>";
        }

        $tableSchema = Yii::$app->db->schema->getTableSchema('{{%edition}}');
        if ($tableSchema) {
            echo "<br><h4>Table Schema:</h4>";
            foreach ($tableSchema->columns as $columnName => $column) {
                echo "Column: {$columnName}, Type: {$column->type}, Allow Null: "
                    . ($column->allowNull ? 'Yes' : 'No')
                    . ", Default: {$column->defaultValue}<br>";
            }
        }
        exit;
    }

    public function actionFixCodes()
    {
        $editions = Edition::find()->all();
        $fixed = 0;

        foreach ($editions as $edition) {
            if (empty($edition->code)) {
                $edition->code = $edition->generateUniqueCode();
                if ($edition->save(false)) {
                    $fixed++;
                    echo "Fixed edition #{$edition->id}: {$edition->title} -> Code: {$edition->code}<br>";
                }
            }
        }

        echo "<br>Total fixed: {$fixed} editions";
        exit;
    }
}
