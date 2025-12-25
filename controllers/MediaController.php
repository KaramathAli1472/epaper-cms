<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\models\Media;

class MediaController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Media::find()->orderBy(['id' => SORT_DESC]),
        ]);

        // direct upload form ke liye khali model
        $uploadModel = new Media();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'uploadModel'  => $uploadModel,
        ]);
    }

    /**
     * Direct upload action (index se hidden form submit hoga)
     */
    public function actionUpload()
    {
        $model = new Media();

        if (Yii::$app->request->isPost) {

            $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');

            if ($model->uploadFile && $model->validate(['uploadFile'])) {

                $fileName   = time() . '_' . $model->uploadFile->baseName . '.' . $model->uploadFile->extension;
                $uploadPath = Yii::getAlias('@webroot/uploads/media/' . $fileName);

                if ($model->uploadFile->saveAs($uploadPath)) {
                    $model->file_name = $fileName;
                    $model->file_path = '/uploads/media/' . $fileName;
                    $model->status    = 1; // default active
                    $model->save(false);
                }
            }
        }

        return $this->redirect(['media/index']); // same page par wapas
    }

    /**
     * AJAX se delete karne ka action
     */
    public function actionDelete()
    {
        // Set response format to JSON
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // Only accept POST requests
        if (!Yii::$app->request->isPost) {
            return ['success' => false, 'message' => 'Invalid request method'];
        }
        
        $id = Yii::$app->request->post('id');
        
        if (!$id) {
            return ['success' => false, 'message' => 'ID is required'];
        }
        
        $model = Media::findOne($id);
        if (!$model) {
            return ['success' => false, 'message' => 'Media not found'];
        }
        
        try {
            // File bhi delete karein (optional)
            $filePath = Yii::getAlias('@webroot') . $model->file_path;
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            
            // Delete from database
            if ($model->delete()) {
                return ['success' => true, 'message' => 'Media deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to delete media from database'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    /**
     * AJAX se update karne ka action
     */
    public function actionUpdateAjax()
    {
        // Set response format to JSON
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // Only accept POST requests
        if (!Yii::$app->request->isPost) {
            return ['success' => false, 'message' => 'Invalid request method'];
        }
        
        $id = Yii::$app->request->post('id');
        $title = Yii::$app->request->post('title');
        $caption = Yii::$app->request->post('caption');
        
        if (!$id) {
            return ['success' => false, 'message' => 'ID is required'];
        }
        
        $model = Media::findOne($id);
        if (!$model) {
            return ['success' => false, 'message' => 'Media not found'];
        }
        
        try {
            $model->title = $title ?? $model->title;
            $model->caption = $caption ?? $model->caption;
            
            if ($model->save(false)) {
                return ['success' => true, 'message' => 'Updated successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to update'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}