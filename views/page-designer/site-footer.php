<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Edit Layout: Site Footer';

// current page
$current = 'site-footer';

// sab layouts ke links
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

// back URL -> Page Designer index
$backUrl = Url::to(['page-designer/index']);
?>
<style>
.layout-select-wrap {
    position: relative;
    display: inline-block;
}
.layout-select-wrap select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    padding-right: 24px;
}
.layout-select-wrap .layout-select-arrow {
    position: absolute;
    top: 50%;
    right: 8px;
    transform: translateY(-50%);
    pointer-events: none;
    color: #374151;
    font-size: 10px;
}
.widget-line {
    border-top:1px solid #d7dde6;
    border-bottom:1px solid #d7dde6;
    padding:3px 6px;
    display:flex;
    align-items:center;
    justify-content:flex-end;
    background:#f9fafb;
}
.widget-pill {
    background:#1e88e5;
    color:#fff;
    font-size:11px;
    padding:2px 8px;
    border-radius:2px;
}
.widget-tools {
    display:flex;
    align-items:center;
    gap:4px;
}
</style>

<div class="box-style" style="padding:0;">

    <!-- Header + tabs -->
    <div style="padding:10px 15px 0 15px; border-bottom:1px solid #e5e7eb; background:#f9fafb;">
        <h4 style="margin:0 0 8px 0; font-size:16px; font-weight:600;">
            <?= Html::encode($this->title) ?>
        </h4>

        <ul class="nav nav-tabs" style="border-bottom:none; margin:0; padding-left:0;">
            <li class="active">
                <a href="#designer" data-toggle="tab"
                   style="border:1px solid #e5e7eb; border-bottom-color:transparent;
                          border-radius:0; padding:6px 18px; font-size:13px;">
                    Designer
                </a>
            </li>
            <li>
                <a href="#backups" data-toggle="tab"
                   style="border:1px solid transparent; border-bottom-color:transparent;
                          border-radius:0; padding:6px 18px; font-size:13px;">
                    Layout Backups
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content" style="padding:10px 15px 15px;">
        <div class="tab-pane active" id="designer">

            <!-- Top buttons row -->
            <div style="margin-bottom:10px; display:flex; gap:6px; flex-wrap:wrap;">
                <a href="<?= $backUrl ?>" class="btn btn-default btn-xs" style="min-width:80px; text-decoration:none;">
                    <i class="glyphicon glyphicon-arrow-left"></i> Back
                </a>

                <button class="btn btn-default btn-xs" style="background:#4b5563; color:#fff; border-color:#4b5563;">
                    <i class="glyphicon glyphicon-floppy-disk"></i> Save as Draft
                </button>
                <button class="btn btn-primary btn-xs" style="background:#2563eb; border-color:#2563eb;">
                    <i class="glyphicon glyphicon-ok"></i> Save and Publish
                </button>
                <button class="btn btn-default btn-xs" style="background:#6b7280; color:#fff; border-color:#6b7280;">
                    Preview Mode Off
                </button>

                <!-- Right side dropdown with arrow -->
                <div style="margin-left:auto;">
                    <div class="layout-select-wrap">
                        <select class="form-control input-sm"
                                style="height:26px; padding:2px 24px 2px 8px; font-size:12px; min-width:180px;"
                                onchange="if(this.value){ window.location=this.value; }">
                            <option value="<?= Html::encode($links['site-header']) ?>"
                                <?= $current==='site-header' ? 'selected' : '' ?>>
                                Site Header
                            </option>
                            <option value="<?= Html::encode($links['site-footer']) ?>"
                                <?= $current==='site-footer' ? 'selected' : '' ?>>
                                Site Footer
                            </option>
                            <option value="<?= Html::encode($links['static-page']) ?>">
                                Static Page
                            </option>
                            <option value="<?= Html::encode($links['homepage']) ?>">
                                Website Homepage
                            </option>
                            <option value="<?= Html::encode($links['epaper-archive']) ?>">
                                Epaper Archive
                            </option>
                            <option value="<?= Html::encode($links['epaper-display']) ?>">
                                Epaper Display
                            </option>
                            <option value="<?= Html::encode($links['epaper-map']) ?>">
                                Epaper Map
                            </option>
                            <option value="<?= Html::encode($links['epaper-clip']) ?>">
                                Epaper Clip
                            </option>
                        </select>
                        <span class="glyphicon glyphicon-menu-down layout-select-arrow"></span>
                    </div>
                </div>
            </div>

            <!-- Blue tools bar -->
            <div style="
                margin:0 -15px 10px -15px;
                padding:6px 10px;
                background:#3f51b5;
                display:flex;
                justify-content:space-between;
                align-items:center;
                color:#fff;
            ">
                <div>
                    <button class="btn btn-success btn-xs" style="background:#2196f3; border-color:#1e88e5;">
                        <i class="glyphicon glyphicon-plus"></i> Add Row
                    </button>
                    <button class="btn btn-default btn-xs"
                            style="background:#303f9f; color:#fff; border-color:#283593;">
                        <i class="glyphicon glyphicon-console"></i> Custom CSS/JS
                    </button>
                </div>
                <button class="btn btn-warning btn-xs" style="background:#ffc107; border-color:#ffb300;">
                    <i class="glyphicon glyphicon-fullscreen"></i> Extra Large
                </button>
            </div>

            <!-- Outer row wrapper (light grey) -->
            <div style="border:1px solid #d1d5db; margin-bottom:10px; background:#f5f7fb;">

                <!-- Row tools -->
                <div style="padding:6px 8px; border-bottom:1px solid #d1d5db;
                            background:#e8f0fe; display:flex; align-items:center; gap:6px;">
                    <button class="btn btn-primary btn-xs" style="background:#2196f3; border-color:#1e88e5;">
                        <i class="glyphicon glyphicon-plus"></i> Add Column
                    </button>

                    <button class="btn btn-default btn-xs" style="color:#333;">
                        <i class="glyphicon glyphicon-move"></i>
                    </button>

                    <button class="btn btn-danger btn-xs">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>

                <!-- Inner area for columns -->
                <div style="padding:8px 10px;">

                    <div style="border:1px solid #cbd5e1; background:#ffffff;">

                        <div style="padding:6px 8px; border-bottom:1px solid #e5e7eb;
                                    background:#f1f5f9; display:flex; align-items:center; gap:4px;">
                            <button class="btn btn-default btn-xs" style="background:#10b981; color:#fff; border-color:#059669;">
                                <i class="glyphicon glyphicon-plus"></i> Add Widgets
                            </button>

                            <button class="btn btn-default btn-xs">
                                <i class="glyphicon glyphicon-move"></i>
                            </button>

                            <button class="btn btn-primary btn-xs" style="background:#2563eb; border-color:#1d4ed8;">
                                <i class="glyphicon glyphicon-plus"></i>
                            </button>

                            <button class="btn btn-default btn-xs">
                                <i class="glyphicon glyphicon-minus"></i>
                            </button>

                            <button class="btn btn-default btn-xs" style="background:#e5e7eb;">
                                <i class="glyphicon glyphicon-th-large"></i> Add Nested Row
                            </button>
                        </div>

                        <!-- HTMLWidget pill right side -->
                        <div style="padding:0 0 8px 0;">
                            <div class="widget-line">
                                <div class="widget-tools">
                                    <span class="widget-pill">HTMLWidget</span>
                                    <button class="btn btn-default btn-xs">
                                        <i class="glyphicon glyphicon-duplicate"></i>
                                    </button>
                                    <button class="btn btn-success btn-xs">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-xs">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div style="height:20px;"></div>
                </div>
            </div>

        </div>

        <div class="tab-pane" id="backups">
            <p>Layout backups for Site Footer yahan dikhenge (coming soon).</p>
        </div>
    </div>
</div>
