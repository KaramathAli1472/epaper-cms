<?php

namespace app\controllers;

use yii\web\Controller;

class WidgetShortcodeController extends Controller
{
    public function actionIndex()
    {
        // yahan se data bhejna ho to bhej sakte ho
        return $this->render('index');
    }
}
