<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Page Designer Manager';

$layouts = [
    [
        'label' => 'Site Header',
        'url'   => Url::to(['page-designer/layout', 'id' => 'site-header']),
    ],
    [
        'label' => 'Site Footer',
        'url'   => Url::to(['page-designer/site-footer']),
    ],
    [
        'label' => 'Static Page',
        'url'   => Url::to(['page-designer/static-page']),
    ],
    [
        'label' => 'Website Homepage',
        'url'   => Url::to(['page-designer/website-homepage']),
    ],
    [
        'label' => 'Epaper Archive',
        'url'   => Url::to(['page-designer/epaper-archive']),
    ],
    [
        'label' => 'Epaper Display',
        'url'   => Url::to(['page-designer/epaper-display']),
    ],
    [
        'label' => 'Epaper Map',
        'url'   => Url::to(['page-designer/epaper-map']),
    ],
    [
        'label' => 'Epaper Clip',
        'url'   => Url::to(['page-designer/epaper-clip']),
    ],
];
?>

<div class="box-style" style="padding:0;">

    <!-- Header + tabs -->
    <div style="padding:0 15px; border-bottom:1px solid #e5e7eb; background:#f9fafb;">
        <div style="padding-top:10px;">
            <h4 style="margin:0 0 8px 0; font-size:16px; font-weight:600;">
                <?= Html::encode($this->title) ?>
            </h4>
        </div>

        <ul class="nav nav-tabs" style="border-bottom:none; margin:0; padding-left:0;">
            <li class="active">
                <a href="#designer" data-toggle="tab"
                   style="border:1px solid #e5e7eb; border-bottom-color:transparent;
                          border-radius:0; padding:8px 22px; font-size:13px;">
                    Designer
                </a>
            </li>
            <li>
                <a href="#backups" data-toggle="tab"
                   style="border:1px solid transparent; border-bottom-color:transparent;
                          border-radius:0; padding:8px 22px; font-size:13px;">
                    Layout Backups
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content" style="padding:10px 15px 15px;">
        <div class="tab-pane active" id="designer">

            <!-- Top button row -->
            <div style="
                margin:0 -15px 10px -15px;
                padding:6px 10px;
                background:#f3f4f6;
                border-bottom:1px solid #e5e7eb;
                display:flex;
                gap:6px;
                flex-wrap:wrap;
            ">
                <button class="btn btn-default btn-xs"
                        style="background:#9ca3af; color:#fff; border-color:#9ca3af; min-width:150px;">
                    Preview Mode Off
                </button>
                <button class="btn btn-primary btn-xs"
                        style="background:#1d4ed8; border-color:#1d4ed8; min-width:210px;">
                    <i class="glyphicon glyphicon-floppy-disk"></i> Backup Current Layout Online
                </button>
                <button class="btn btn-success btn-xs"
                        style="background:#16a34a; border-color:#16a34a; min-width:190px;">
                    <i class="glyphicon glyphicon-download"></i> Download Offline Backup
                </button>
                <button class="btn btn-success btn-xs"
                        style="background:#059669; border-color:#059669; min-width:180px;">
                    <i class="glyphicon glyphicon-upload"></i> Upload Offline Backup
                </button>
            </div>

            <!-- Header row for table -->
            <div style="
                margin:0 -15px;
                padding:6px 15px;
                background:#f9fafb;
                border-top:1px solid #e5e7eb;
                border-bottom:1px solid #e5e7eb;
                display:flex;
                font-size:12px;
                font-weight:600;
                color:#4b5563;
            ">
                <div style="width:120px;">Actions</div>
                <div style="flex:1;">Layouts</div>
            </div>

            <table class="table" style="margin-bottom:0;">
                <tbody>
                <?php foreach ($layouts as $row): ?>
                    <tr>
                        <td style="width:120px;">
                            <a href="<?= Html::encode($row['url']) ?>"
                               style="color:#16a34a; font-weight:600; text-decoration:none;">
                                Published!
                            </a>
                        </td>
                        <td>
                            <a href="<?= Html::encode($row['url']) ?>"
                               style="color:#2563eb; font-weight:500; text-decoration:none;">
                                <?= Html::encode($row['label']) ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="tab-pane" id="backups">
            <p>Layout backups for this section will appear here.</p>
        </div>
    </div>
</div>
