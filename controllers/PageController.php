<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\base\InvalidConfigException;
use yii\web\UploadedFile;
use app\models\Edition;
use app\models\Page;
use app\models\PageArea;

class PageController extends Controller
{
    public function actionIndex($edition_id = null)
    {
        if ($edition_id !== null) {
            $edition = Edition::findOne($edition_id);
            if ($edition === null) {
                throw new NotFoundHttpException('Edition not found.');
            }
            $query = Page::find()
                ->where(['edition_id' => $edition_id])
                ->orderBy(['page_no' => SORT_ASC]);
        } else {
            $edition = null;
            $query = Page::find()->orderBy(['page_no' => SORT_ASC]);
        }

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'edition'      => $edition,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * MODAL CREATE - SIRF FORM RETURN KAREGA
     */
    public function actionCreate($edition_id = null)
    {
        $model = new Page();

        if ($edition_id !== null) {
            $model->edition_id = (int)$edition_id;
            $max = (int)Page::find()->where(['edition_id' => $model->edition_id])->max('page_no');
            $model->page_no = $max ? ($max + 1) : 1;
        } else {
            $max = (int)Page::find()->max('page_no');
            $model->page_no = $max ? ($max + 1) : 1;
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Page created successfully.');
                
                // AJAX request hai to JSON return karo
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => true, 'message' => 'Page created successfully!'];
                }
                
                return $this->redirect(['index', 'edition_id' => $model->edition_id]);
            } else {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => false, 'errors' => $model->errors];
                }
                Yii::$app->session->setFlash('error', 'Unable to create page. Please check input.');
            }
        }

        // AJAX/MODAL request hai to sirf form return karo
        if (Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * MODAL UPDATE - SIRF FORM RETURN KAREGA
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Page updated successfully.');
                
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => true, 'message' => 'Page updated successfully!'];
                }
                
                return $this->redirect(['index', 'edition_id' => $model->edition_id]);
            } else {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => false, 'errors' => $model->errors];
                }
            }
        }

        // AJAX/MODAL request hai to sirf form return karo
        if (Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUploadJpg($edition_id)
    {
        $edition = Edition::findOne($edition_id);
        if ($edition === null) {
            throw new NotFoundHttpException('Edition not found.');
        }

        if (Yii::$app->request->isPost) {
            $files = UploadedFile::getInstancesByName('files');

            $pageNo = (int) Page::find()
                    ->where(['edition_id' => $edition_id])
                    ->max('page_no') + 1;

            $uploadPath = Yii::getAlias('@webroot/uploads/pages/');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            foreach ($files as $file) {
                $fileName = time() . '_' . $file->baseName . '.' . $file->extension;
                $fullPath = $uploadPath . $fileName;

                if ($file->saveAs($fullPath)) {
                    $page = new Page();
                    $page->edition_id = $edition_id;
                    $page->page_no    = $pageNo++;
                    $page->title      = $file->baseName;

                    $relativeUrl      = '/uploads/pages/' . $fileName;
                    $page->image      = $relativeUrl;
                    $page->thumb_url  = $relativeUrl;
                    $page->file_size  = round($file->size / 1024) . ' KB';

                    $page->save(false);
                }
            }

            return $this->redirect(['index', 'edition_id' => $edition_id]);
        }

        return $this->render('upload-jpg', [
            'edition' => $edition,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $editionId = $model->edition_id;
        $model->delete();

        Yii::$app->session->setFlash('success', 'Page deleted successfully.');
        return $this->redirect(['index', 'edition_id' => $editionId]);
    }

    /* ===========================
     *  AREA MAPS
     * =========================== */

    public function actionAreas($id)
    {
        $model = $this->findModel($id);
        $areas = $model->areas;

        return $this->render('areas', [
            'model' => $model,
            'areas' => $areas,
        ]);
    }

    public function actionSaveAreas($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = $this->findModel($id);

        $json = Yii::$app->request->post('areas');
        if (!$json) {
            return ['success' => false, 'message' => 'No data'];
        }

        $data = json_decode($json, true);
        if (!is_array($data)) {
            return ['success' => false, 'message' => 'Invalid JSON'];
        }

        PageArea::deleteAll(['page_id' => $model->id]);

        foreach ($data as $a) {
            $area = new PageArea();
            $area->page_id = $model->id;
            $area->x       = (int)($a['x'] ?? 0);
            $area->y       = (int)($a['y'] ?? 0);
            $area->width   = (int)($a['width'] ?? 0);
            $area->height  = (int)($a['height'] ?? 0);
            $area->link    = $a['link']  ?? null;
            $area->title   = $a['title'] ?? null;
            $area->save(false);
        }

        return ['success' => true];
    }

    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Page not found.');
    }
}
