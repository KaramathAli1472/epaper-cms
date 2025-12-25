<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Slider;   // apne model ka namespace yahan lagana

class SliderController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Slider::find()->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // Agar zarurat ho to yahan create/update/delete actions bhi bana sakte ho
    // public function actionCreate() {...}
    // public function actionUpdate($id) {...}
    // public function actionDelete($id) {...}
}
