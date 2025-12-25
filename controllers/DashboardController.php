<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class DashboardController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],   // sirf logged-in users
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        // TODO: yahan real disk/traffic values calculate karo
        $storageTotal = 0;   // bytes, e.g. 100 * 1024 * 1024 * 1024;
        $storageUsed  = 0;   // bytes, e.g. 50 * 1024 * 1024 * 1024;
        $trafficTotal = 0;   // pageviews, e.g. 300000;
        $trafficUsed  = 0;   // pageviews, e.g. 150000;

        return $this->render('index', [
            'storageTotal' => $storageTotal,
            'storageUsed'  => $storageUsed,
            'trafficTotal' => $trafficTotal,
            'trafficUsed'  => $trafficUsed,
        ]);
    }
}

