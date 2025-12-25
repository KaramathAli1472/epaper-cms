<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;

class PageDesignerController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    // Site Header / generic layout builder (layout.php)
    public function actionLayout($id)
    {
        // current layout key (site-header, etc.)
        $current = $id;

        // sab layouts ke links (dropdown ke liye)
        $links = [
            'site-header'      => Url::to(['page-designer/layout', 'id' => 'site-header']),
            'site-footer'      => Url::to(['page-designer/site-footer']),
            'static-page'      => Url::to(['page-designer/static-page']),
            'homepage'         => Url::to(['page-designer/website-homepage']),
            'epaper-archive'   => Url::to(['page-designer/epaper-archive']),
            'epaper-display'   => Url::to(['page-designer/epaper-display']),
            'epaper-map'       => Url::to(['page-designer/epaper-map']),
            'epaper-clip'      => Url::to(['page-designer/epaper-clip']),
        ];

        // back button URL
        $backUrl = Url::to(['page-designer/index']);

        return $this->render('layout', [
            'id'      => $id,
            'current' => $current,
            'links'   => $links,
            'backUrl' => $backUrl,
        ]);
    }

    // Site Footer view
    public function actionSiteFooter()
    {
        return $this->render('site-footer');
    }

    // Static Page view
    public function actionStaticPage()
    {
        return $this->render('static-page');
    }

    // Website Homepage view
    public function actionWebsiteHomepage()
    {
        return $this->render('website-homepage');
    }

    // Epaper Archive
    public function actionEpaperArchive()
    {
        return $this->render('epaper-archive');
    }

    // Epaper Display
    public function actionEpaperDisplay()
    {
        return $this->render('epaper-display');
    }

    // Epaper Map
    public function actionEpaperMap()
    {
        return $this->render('epaper-map');
    }

    // Epaper Clip
    public function actionEpaperClip()
    {
        return $this->render('epaper-clip');
    }
}
