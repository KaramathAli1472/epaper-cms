<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<aside class="main-sidebar">
    <section class="sidebar">

        <!-- User panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/images/user.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= Html::encode(Yii::$app->user->identity->username ?? 'Admin') ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- SIDEBAR MENU -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGATION</li>

            <!-- Dashboard -->
            <li class="<?= Yii::$app->controller->id === 'site' ? 'active' : '' ?>">
                <a href="<?= Url::to(['site/index']) ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <!-- Epaper -->
            <li class="<?= Yii::$app->controller->id === 'epaper' ? 'active' : '' ?>">
                <a href="<?= Url::to(['epaper/index']) ?>">
                    <i class="fa fa-newspaper-o"></i> <span>Epaper</span>
                </a>
            </li>

            <!-- Page Manager -->
            <li class="<?= Yii::$app->controller->id === 'page' ? 'active' : '' ?>">
                <a href="<?= Url::to(['page/index']) ?>">
                    <i class="fa fa-file-text-o"></i> <span>Page</span>
                </a>
            </li>

            <!-- SLIDER (yeh woh item hai jisko click karne par slider page open hoga) -->
            <li class="<?= Yii::$app->controller->id === 'slider' ? 'active' : '' ?>">
                <a href="<?= Url::to(['slider/index']) ?>">
                    <i class="fa fa-picture-o"></i> <span>Slider</span>
                </a>
            </li>

            <!-- Media -->
            <li class="<?= Yii::$app->controller->id === 'media' ? 'active' : '' ?>">
                <a href="<?= Url::to(['media/index']) ?>">
                    <i class="fa fa-photo"></i> <span>Media</span>
                </a>
            </li>

            <!-- Users -->
            <li class="<?= Yii::$app->controller->id === 'user' ? 'active' : '' ?>">
                <a href="<?= Url::to(['user/index']) ?>">
                    <i class="fa fa-users"></i> <span>Users</span>
                </a>
            </li>

            <!-- System -->
            <li class="treeview <?= in_array(Yii::$app->controller->id, ['setting','log']) ? 'active' : '' ?>">
                <a href="#">
                    <i class="fa fa-cog"></i> <span>System</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= Url::to(['setting/index']) ?>"><i class="fa fa-circle-o"></i> Settings</a></li>
                    <li><a href="<?= Url::to(['log/index']) ?>"><i class="fa fa-circle-o"></i> Logs</a></li>
                </ul>
            </li>

            <!-- Logout -->
            <li>
                <a href="<?= Url::to(['site/logout']) ?>" data-method="post">
                    <i class="fa fa-sign-out"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
