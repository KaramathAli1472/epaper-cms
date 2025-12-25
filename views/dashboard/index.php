<?php
/** @var yii\web\View $this */
/** @var int|null $storageTotal */
/** @var int|null $storageUsed */
/** @var int|null $trafficTotal */
/** @var int|null $trafficUsed */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Admin Dashboard';

// Defaults (agar controller se vars na aaye ho)
$storageTotal  = $storageTotal  ?? 0;   // bytes
$storageUsed   = $storageUsed   ?? 0;   // bytes
$trafficTotal  = $trafficTotal  ?? 0;   // pageviews
$trafficUsed   = $trafficUsed   ?? 0;

// Flags
$hasStorageData = $storageTotal > 0 && $storageUsed > 0;
$hasTrafficData = $trafficTotal > 0 && $trafficUsed > 0;

// Calculations
$storageAvailable  = max($storageTotal - $storageUsed, 0);
$trafficAvailable  = max($trafficTotal - $trafficUsed, 0);

// bytes → GB helper
$toGb = function ($bytes) {
    return round($bytes / (1024 * 1024 * 1024), 1); // 1 decimal
};
?>
<style>
.dashboard-page {
    background: #f3f5f7;
    padding: 15px;
}
.dashboard-header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}
.dashboard-header-bar h4 {
    margin: 0;
}
.logout-btn {
    background: #f44336;
    border: none;
    color: #fff;
    padding: 6px 14px;
    border-radius: 3px;
    font-weight: 600;
    cursor: pointer;
}

/* top tiles */
.dashboard-top-buttons .btn-tile {
    width: 100%;
    padding: 20px 10px;
    color: #fff;
    font-size: 20px;
    font-weight: 600;
    border-radius: 3px;
    border: none;
    text-align: center;
    text-decoration: none;
    display: block;
    transition: transform 0.2s, box-shadow 0.2s;
}
.dashboard-top-buttons .btn-tile:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
.btn-publish { background: #3f51b5; }
.btn-domain  { background: #009688; }
.btn-help    { background: #ffc107; color: #333; }
.btn-expiry  { background: #e91e63; }
.btn-edition { background: #673ab7; } /* NEW - Edition Manager */
.btn-site    { background: #2196f3; } /* NEW - Site Homepage */

.dashboard-card {
    background: #fff;
    border-radius: 3px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.dashboard-card-header {
    background: #3f51b5;
    color: #fff;
    padding: 8px 15px;
    font-weight: 600;
}
.dashboard-card-body {
    padding: 15px;
}

/* Simple placeholder pies */
.pie-placeholder {
    width: 260px;
    height: 260px;
    border-radius: 50%;
    margin: 0 auto;
    background: conic-gradient(#ff5b7f 0 80%, #eeeeee 80% 100%);
    position: relative;
}
.pie-placeholder span {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-weight: 600;
    color: #333;
    font-size: 24px;
}

/* Table strip at bottom of cards */
.table-strip {
    display: flex;
    width: 100%;
    text-align: center;
    color: #fff;
    margin-top: 15px;
    border-radius: 3px;
    overflow: hidden;
}
.table-strip div {
    flex: 1;
    padding: 8px 5px;
    font-weight: 600;
}
.strip-total { background: #2196f3; }
.strip-used  { background: #f44336; }
.strip-free  { background: #4caf50; }
</style>

<div class="dashboard-page">

    <!-- Header + Logout -->
    <div class="dashboard-header-bar">
        <h4>Welcome to Admin Dashboard</h4>
        <div>
            <a href="<?= Url::to(['site/index']) ?>" class="btn btn-sm btn-outline-primary me-2">
                <i class="fas fa-home"></i> View Site
            </a>
            <?= Html::beginForm(['site/logout'], 'post') ?>
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            <?= Html::endForm() ?>
        </div>
    </div>

    <!-- Top tiles - Updated with more options -->
    <div class="row dashboard-top-buttons mb-3">
        <div class="col-md-2 mb-2">
            <a href="<?= Url::to(['site/index']) ?>" class="btn-tile btn-site">
                🏠 Site Home
            </a>
        </div>
        <div class="col-md-2 mb-2">
            <a href="#" class="btn-tile btn-publish">
                📰 Publish Epaper
            </a>
        </div>
        <div class="col-md-2 mb-2">
            <a href="<?= Url::to(['edition/index']) ?>" class="btn-tile btn-edition">
                📑 Edition Manager
            </a>
        </div>
        <div class="col-md-2 mb-2">
            <a href="#" class="btn-tile btn-domain">
                🌐 Domain
            </a>
        </div>
        <div class="col-md-2 mb-2">
            <a href="#" class="btn-tile btn-help">
                ❓ Help
            </a>
        </div>
        <div class="col-md-2 mb-2">
            <a href="#" class="btn-tile btn-expiry">
                🔁 Expiry
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Disk Usage -->
        <div class="col-md-6">
            <div class="dashboard-card">
                <div class="dashboard-card-header">Disk Usage</div>
                <div class="dashboard-card-body">
                    <div class="pie-placeholder">
                        <span>
                            <?php
                            if ($hasStorageData && $storageTotal > 0) {
                                echo round(($storageUsed / $storageTotal) * 100, 1) . '%';
                            } else {
                                echo '0%';
                            }
                            ?>
                        </span>
                    </div>

                    <div class="table-strip">
                        <?php if ($hasStorageData): ?>
                            <div class="strip-total">
                                Total: <?= $toGb($storageTotal) ?> GB
                            </div>
                            <div class="strip-used">
                                Used: <?= $toGb($storageUsed) ?> GB
                            </div>
                            <div class="strip-free">
                                Available: <?= $toGb($storageAvailable) ?> GB
                            </div>
                        <?php else: ?>
                            <div class="strip-total" style="flex:1;">
                                No disk usage data yet
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Traffic usage -->
        <div class="col-md-6">
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    Traffic Usage In Pageviews for December 2025
                </div>
                <div class="dashboard-card-body">
                    <div class="pie-placeholder" style="background:
                        <?php if ($hasTrafficData && $trafficTotal > 0): ?>
                            conic-gradient(#4caf50 0 <?= ($trafficUsed / $trafficTotal) * 100 ?>%, #ff5b7f <?= ($trafficUsed / $trafficTotal) * 100 ?>% 100%);
                        <?php else: ?>
                            conic-gradient(#eeeeee 0 100%);
                        <?php endif; ?>
                    ">
                        <span>
                            <?php
                            if ($hasTrafficData && $trafficTotal > 0) {
                                echo number_format($trafficUsed) . ' (' . round(($trafficUsed / $trafficTotal) * 100, 1) . '%)';
                            } else {
                                echo '0 (0%)';
                            }
                            ?>
                        </span>
                    </div>

                    <div class="table-strip">
                        <?php if ($hasTrafficData): ?>
                            <div class="strip-total">
                                Total: <?= number_format($trafficTotal) ?>
                            </div>
                            <div class="strip-used">
                                Used: <?= number_format($trafficUsed) ?>
                            </div>
                            <div class="strip-free">
                                Available: <?= number_format($trafficAvailable) ?>
                            </div>
                        <?php else: ?>
                            <div class="strip-total" style="flex:1;">
                                No traffic data yet
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Website traffic placeholder (line chart area) -->
    <div class="row">
        <div class="col-md-12">
            <div class="dashboard-card">
                <div class="dashboard-card-header">Website Traffic</div>
                <div class="dashboard-card-body">
                    <p>Traffic in (Pageviews)</p>
                    <div style="height:200px;border:1px solid #e0e0e0;background:#fafafa;text-align:center;padding-top:80px;">
                        Line chart placeholder
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
// Simple interactivity
document.addEventListener('DOMContentLoaded', function() {
    // Add click effect to tiles
    const tiles = document.querySelectorAll('.btn-tile');
    tiles.forEach(tile => {
        tile.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
});
</script>
