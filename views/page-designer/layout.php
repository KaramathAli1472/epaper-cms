<?php
use yii\helpers\Html;

/* @var $id string */
/* @var $current string */
/* @var $links array */
/* @var $backUrl string */

$layoutLabel = ucfirst(str_replace('-', ' ', $id));
$this->title = 'Edit Layout: ' . $layoutLabel;
?>
<style>
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
.layout-select-wrap {
    position: relative;
    display: inline-block;
}
.layout-select-wrap select {
    -webkit-appearance:none;
    -moz-appearance:none;
    appearance:none;
    padding-right:22px;
}
.layout-select-wrap .layout-select-arrow {
    position:absolute;
    top:50%;
    right:7px;
    transform:translateY(-50%);
    pointer-events:none;
    color:#6b7280;
    font-size:10px;
}
</style>

<div class="box-style" style="padding:0;">

    <!-- Header + tabs -->
    <div style="padding:10px 15px 0 15px; border-bottom:1px solid #dcdcdc; background:#f5f5f5;">
        <h4 style="margin:0 0 8px 0; font-size:16px; font-weight:600;">
            <?= Html::encode($this->title) ?>
        </h4>

        <ul class="nav nav-tabs" style="border-bottom:none; margin:0; padding-left:0;">
            <li class="active">
                <a href="#designer" data-toggle="tab"
                   style="border:1px solid #dcdcdc; border-bottom-color:transparent;
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
                <div style="display:flex; gap:6px;">
                    <button class="btn btn-success btn-xs">
                        <i class="glyphicon glyphicon-plus"></i> Add Row
                    </button>
                    <button class="btn btn-default btn-xs"
                            style="background:#263238; color:#fff; border-color:#263238;">
                        &lt;/&gt; Custom CSS/JS
                    </button>
                </div>
                <button class="btn btn-warning btn-xs">
                    <i class="glyphicon glyphicon-modal-window"></i> Extra Large
                </button>
            </div>

            <?php
            // helper for one full-width column with toolbar
            $renderColumn = function ($widgetLabel = '') {
                ?>
                <div style="border:1px solid #d1d5db; background:#ffffff; margin-bottom:8px;">

                    <!-- column tools -->
                    <div style="
                        padding:4px 6px;
                        border-bottom:1px solid #e5e7eb;
                        background:#f7f7f7;
                        display:flex;
                        align-items:center;
                        gap:4px;
                    ">
                        <button class="btn btn-default btn-xs">
                            <i class="glyphicon glyphicon-plus"></i> Add Widgets
                        </button>
                        <button class="btn btn-info btn-xs">
                            <i class="glyphicon glyphicon-th-list"></i>
                        </button>
                        <button class="btn btn-primary btn-xs">
                            <i class="glyphicon glyphicon-plus"></i>
                        </button>
                        <button class="btn btn-default btn-xs">
                            <i class="glyphicon glyphicon-minus"></i>
                        </button>
                        <button class="btn btn-default btn-xs">
                            <i class="glyphicon glyphicon-star"></i> Add Nested Row
                        </button>
                    </div>

                    <!-- widget area -->
                    <div style="padding:0 0 6px 0;">
                        <?php if ($widgetLabel): ?>
                            <div class="widget-line">
                                <div class="widget-tools">
                                    <span class="widget-pill"><?= Html::encode($widgetLabel) ?></span>
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
                        <?php endif; ?>
                        <div style="border:1px dashed #cbd5e1; height:32px;"></div>
                    </div>
                </div>
                <?php
            };

            // helper for row wrapper
            $renderRow = function ($widgetLabel = '') use ($renderColumn) {
                ?>
                <div style="border:1px solid #e5e7eb; margin-bottom:10px; background:#f9fafb;">

                    <!-- row tools -->
                    <div style="
                        padding:4px 8px;
                        border-bottom:1px solid #e5e7eb;
                        background:#e3e7ff;
                        display:flex;
                        align-items:center;
                        gap:4px;
                    ">
                        <button class="btn btn-success btn-xs">
                            <i class="glyphicon glyphicon-plus"></i> Add Column
                        </button>
                        <button class="btn btn-default btn-xs">
                            <i class="glyphicon glyphicon-resize-horizontal"></i>
                        </button>
                        <button class="btn btn-danger btn-xs">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </div>

                    <!-- columns wrapper -->
                    <div style="padding:6px 8px 10px 8px;">
                        <?php $renderColumn($widgetLabel); ?>
                    </div>
                </div>
                <?php
            };
            ?>

            <!-- Example rows -->
            <div style="border:1px solid #e5e7eb; margin-bottom:10px; background:#f9fafb;">
                <div style="
                    padding:4px 8px;
                    border-bottom:1px solid #e5e7eb;
                    background:#e3e7ff;
                    display:flex;
                    align-items:center;
                    gap:4px;
                ">
                    <button class="btn btn-success btn-xs">
                        <i class="glyphicon glyphicon-plus"></i> Add Column
                    </button>
                    <button class="btn btn-default btn-xs">
                        <i class="glyphicon glyphicon-resize-horizontal"></i>
                    </button>
                    <button class="btn btn-danger btn-xs">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                </div>

                <div style="padding:6px 8px 10px 8px; display:flex; gap:8px;">
                    <div style="flex:1;">
                        <?php $renderColumn('ImageWidget'); ?>
                    </div>
                    <div style="flex:1;">
                        <?php $renderColumn('ImageWidget'); ?>
                    </div>
                    <div style="flex:1;">
                        <?php $renderColumn('ImageWidget'); ?>
                    </div>
                </div>
            </div>

            <?php $renderRow('NavigationBar'); ?>
            <?php $renderRow('NavigationBar'); ?>
            <?php $renderRow('ImageWidget'); ?>

        </div>

        <div class="tab-pane" id="backups">
            <p>Layout backups for this layout yahan dikhenge (coming soon).</p>
        </div>
    </div>
</div>
