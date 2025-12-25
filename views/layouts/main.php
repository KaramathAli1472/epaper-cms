<?php
/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);

$user = Yii::$app->user->isGuest ? null : Yii::$app->user->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>

    <!-- Bootstrap CSS for Glyphicons -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <!-- FontAwesome for additional icons -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <?php $this->head() ?>

    <style>
        html, body { height: 100%; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f3f5f7;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .topbar {
            height: 56px !important;
            min-height: 56px !important;
            background: #3f51b5;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-sizing: border-box;
        }
        .topbar-left {
            font-size: 16px;
            font-weight: 800;
        }
        .topbar-left span {
            font-weight: 400;
            font-size: 13px;
            opacity: .85;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-top {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 3px;
            border: none;
            cursor: pointer;
        }
        .btn-feedback {
            background: #ff9800;
            color: #fff;
        }
        .user-dropdown { position: relative; }
        .user-btn {
            background: #3949ab;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 3px;
            cursor: pointer;
        }
        .user-menu {
            position: absolute;
            right: 0;
            top: 110%;
            background: #fff;
            color: #333;
            min-width: 140px;
            border-radius: 3px;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
            display: none;
            z-index: 999;
        }
        .user-menu a {
            display: block;
            padding: 6px 10px;
            font-size: 13px;
            color: #333;
            text-decoration: none;
        }
        .user-menu a:hover { background: #f5f5f5; }
        .user-dropdown.open .user-menu { display: block; }

        .page-wrapper {
            flex: 1 0 auto;
            display: flex;
        }

        .sidebar {
            width: 230px;
            background: #2c3e50;
            color: #ecf0f1;
            min-height: calc(100vh - 56px);
        }
        .sidebar .logo {
            padding: 12px 15px;
            font-weight: 600;
            border-bottom: 1px solid #34495e;
        }
        .sidebar .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar .menu > li > a {
            display: block;
            padding: 10px 15px;
            color: #bdc3c7;
            text-decoration: none;
            border-bottom: 1px solid #34495e;
            font-size: 14px;
        }
        .sidebar .menu > li > a i {
            width: 18px;
            margin-right: 6px;
        }
        .sidebar .menu > li > a:hover,
        .sidebar .menu > li.active > a {
            background: #1abc9c;
            color: #fff;
        }
        .sidebar .has-sub > a { position: relative; }
        .sidebar .has-sub > a::after {
            content: "▾";
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
        }
        .sidebar .sub-menu {
            display: none;
            list-style: none;
            padding: 0;
            margin: 0;
            background: #243447;
        }
        .sidebar .sub-menu li a {
            display: block;
            padding: 8px 25px;
            color: #bdc3c7;
            text-decoration: none;
            border-bottom: 1px solid #34495e;
            font-size: 13px;
        }
        .sidebar .sub-menu li a i {
            width: 16px;
            margin-right: 6px;
        }
        .sidebar .sub-menu li a:hover {
            background: #16a085;
            color: #fff;
        }
        .sidebar .has-sub.open > .sub-menu { display: block; }

        .page-content { 
            flex: 1; 
            padding: 10px 15px; 
            background: #fff;
            margin: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
        }

        .page-footer {
            margin-top: auto;
            padding: 4px 15px !important;
            font-size: 14px !important;
            line-height: 1.3 !important;
            height: 36px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e2e4e7ff !important;
            color: #2c3e50 !important;
            font-weight: 500 !important;
        }
        
        .btn-xs {
            padding: 3px 6px !important;
            font-size: 12px !important;
            line-height: 1.3 !important;
            border-radius: 3px !important;
            min-width: 28px !important;
            margin: 1px !important;
            display: inline-block !important;
        }
        
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        
        .table-bordered {
            border: 1px solid #ddd;
        }
        
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > td {
            border: 1px solid #ddd;
            padding: 8px !important;
        }
        
        .table > thead > tr > th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }
        
        .pagination {
            margin: 10px 0 !important;
        }
        
        .alert {
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }
        
        .alert-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<header class="topbar">
    <div class="topbar-left">
        Epaper CMS Cloud <span>/ Admin Panel</span>
    </div>
    <div class="topbar-right">
        <button class="btn-top btn-feedback">Submit Feedback</button>

        <div class="user-dropdown" id="userDropdown">
            <button class="user-btn">
                <i class="fas fa-user"></i>
                <!-- IMPROVED: Show Fullname first, fallback to username -->
                Welcome! <?= $user ? Html::encode($user->fullname ?: $user->username) : 'Guest' ?>
                <i class="fas fa-caret-down"></i>
            </button>
            <div class="user-menu">
                <a href="<?= Url::to(['site/index']) ?>">View Site</a>
                <a href="<?= Url::to(['sitemap/index']) ?>">Sitemap</a>
                <a href="<?= Url::to(['site/change-password']) ?>">Change Password</a>
                <a href="<?= Url::to(['site/logout']) ?>" data-method="post">Logout</a>
            </div>
        </div>
    </div>
</header>

<div class="page-wrapper">
    <aside class="sidebar">
        <div class="logo">
            <i class="fas fa-newspaper"></i> Epaper CMS
        </div>

        <ul class="menu">
            <li class="<?= Yii::$app->controller->id === 'dashboard' ? 'active' : '' ?>">
                <a href="<?= Url::to(['dashboard/index']) ?>">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>

            <li class="has-sub <?= in_array(Yii::$app->controller->id, ['epaper-category','edition','featured-category','epaper-featured-edition','page-category']) ? 'open active' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fas fa-file-alt"></i> Epaper
                </a>
                <ul class="sub-menu">
                    <li class="<?= Yii::$app->controller->id === 'epaper-category' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['epaper-category/index']) ?>"><i class="fas fa-folder"></i> Categories</a>
                    </li>
                    <li class="<?= Yii::$app->controller->id === 'edition' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['edition/index', 'epaper_id' => 1]) ?>"><i class="fas fa-book"></i> Edition</a>
                    </li>
                    <li class="<?= Yii::$app->controller->id === 'featured-category' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['featured-category/index']) ?>"><i class="fas fa-star"></i> Featured Categories</a>
                    </li>
                    <li class="<?= Yii::$app->controller->id === 'epaper-featured-edition' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['epaper-featured-edition/index']) ?>"><i class="fas fa-star-half-alt"></i> Featured Editions</a>
                    </li>
                    <li class="<?= Yii::$app->controller->id === 'page-category' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['page-category/index']) ?>"><i class="fas fa-layer-group"></i> Page Categories</a>
                    </li>
                </ul>
            </li>

            <!-- CMS Page Manager (About Us, Contact Us etc.) -->
            <li class="<?= Yii::$app->controller->id === 'cms-page' ? 'active' : '' ?>">
                <a href="<?= Url::to(['cms-page/index']) ?>"><i class="fas fa-file"></i> Page</a>
            </li>

            <li class="<?= Yii::$app->controller->id === 'slider' ? 'active' : '' ?>">
                <a href="<?= Url::to(['slider/index']) ?>"><i class="fas fa-images"></i> Slider</a>
            </li>

            <li class="<?= Yii::$app->controller->id === 'media' ? 'active' : '' ?>">
                <a href="<?= Url::to(['media/index']) ?>"><i class="fas fa-photo-video"></i> Media</a>
            </li>

            <li class="<?= Yii::$app->controller->id === 'user' ? 'active' : '' ?>">
                <a href="<?= Url::to(['user/index']) ?>"><i class="fas fa-users"></i> Users</a>
            </li>

            <!-- SYSTEM DROPDOWN like screenshot -->
            <li class="has-sub <?= in_array(Yii::$app->controller->id, ['page-designer','widget-shortcode','menu','sitemap','settings']) ? 'open active' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fas fa-cog"></i> System
                </a>
                <ul class="sub-menu">
                    <li class="<?= Yii::$app->controller->id === 'page-designer' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['page-designer/index']) ?>"><i class="fas fa-pencil-alt"></i> Page Designer</a>
                    </li>
                    <li class="<?= Yii::$app->controller->id === 'widget-shortcode' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['widget-shortcode/index']) ?>"><i class="fas fa-code"></i> Widget Shortcodes</a>
                    </li>
                    <li class="<?= Yii::$app->controller->id === 'menu' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['menu/index']) ?>"><i class="fas fa-list"></i> Menus</a>
                    </li>
                    <li class="<?= Yii::$app->controller->id === 'sitemap' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['sitemap/index']) ?>"><i class="fas fa-sitemap"></i> Sitemap</a>
                    </li>
                    <li class="<?= Yii::$app->controller->id === 'settings' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['settings/index']) ?>"><i class="fas fa-sliders-h"></i> Settings</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>

    <div class="page-content">
        <?= $content ?>
    </div>
</div>

<footer class="page-footer text-light text-center">
    Powered by Mg Tech Digital © <?= date('Y') ?>
</footer>

<?php
$js = <<<JS
document.querySelectorAll('.sidebar .has-sub > a').forEach(function(el) {
    el.addEventListener('click', function(e) {
        e.preventDefault();
        this.parentElement.classList.toggle('open');
    });
});

var ud = document.getElementById('userDropdown');
if (ud) {
    ud.querySelector('.user-btn').addEventListener('click', function(e) {
        e.preventDefault();
        ud.classList.toggle('open');
    });
    document.addEventListener('click', function(e) {
        if (!ud.contains(e.target)) {
            ud.classList.remove('open');
        }
    });
}

$(document).ready(function() {
    if (typeof $.fn.tooltip === 'function') {
        $('[title]').tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    }
    
    $('.btn-xs').css({
        'display': 'inline-block',
        'vertical-align': 'middle'
    });
});
JS;
$this->registerJs($js);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
