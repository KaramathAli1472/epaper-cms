<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Edition $model */
/** @var app\models\EpaperCategory $epaper */

$this->title = 'Edition: ' . Html::encode($model->title);
$this->params['breadcrumbs'][] = ['label' => 'E-papers', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => $epaper->name, 'url' => ['index', 'epaper_id' => $epaper->id]];
$this->params['breadcrumbs'][] = Html::encode($model->title);
?>

<div class="edition-view">
    <div class="page-header mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-0"><?= Html::encode($model->title) ?></h1>
            <p class="text-muted mb-0">Epaper: <?= Html::encode($epaper->name) ?></p>
        </div>
        <div class="btn-group">
            <?= Html::a('<i class="fas fa-edit"></i> Edit', 
                ['update', 'id' => $model->id], 
                ['class' => 'btn btn-success']) ?>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Back', 
                ['index', 'epaper_id' => $epaper->id], 
                ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Edition Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small d-block">Title</label>
                                <div class="fw-medium"><?= Html::encode($model->title) ?></div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="text-muted small d-block">Publication Date</label>
                                <div class="fw-medium">
                                    <?= date('d M Y', strtotime($model->date)) ?>
                                    <span class="badge bg-light text-dark ms-2">
                                        <?= Yii::$app->formatter->asRelativeTime($model->date) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="text-muted small d-block">Status</label>
                                <div>
                                    <?php
                                    $statusConfig = [
                                        'active' => ['class' => 'bg-success', 'label' => 'Active'],
                                        'inactive' => ['class' => 'bg-secondary', 'label' => 'Inactive'],
                                        'draft' => ['class' => 'bg-warning', 'label' => 'Draft'],
                                        'archived' => ['class' => 'bg-info', 'label' => 'Archived'],
                                    ];
                                    $config = $statusConfig[$model->status] ?? ['class' => 'bg-secondary', 'label' => ucfirst($model->status)];
                                    ?>
                                    <span class="badge <?= $config['class'] ?>">
                                        <?= $config['label'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small d-block">Created</label>
                                <div class="fw-medium">
                                    <?= date('d M Y H:i', strtotime($model->created_at)) ?>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="text-muted small d-block">Last Updated</label>
                                <div class="fw-medium">
                                    <?= $model->updated_at ? date('d M Y H:i', strtotime($model->updated_at)) : 'Never' ?>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="text-muted small d-block">Epaper</label>
                                <div class="fw-medium">
                                    <?= Html::a(Html::encode($epaper->name), 
                                        ['index', 'epaper_id' => $epaper->id],
                                        ['class' => 'text-primary']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PDF Preview/Download Section -->
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-file-pdf"></i> PDF Document</h5>
                </div>
                <div class="card-body text-center">
                    <?php if ($model->pdf_file): ?>
                        <div class="mb-4">
                            <i class="fas fa-file-pdf fa-4x text-danger mb-3"></i>
                            <h5>PDF Available</h5>
                            <p class="text-muted">Click below to view/download</p>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <?= Html::a('<i class="fas fa-eye"></i> View PDF', 
                                Yii::getAlias('@web') . '/' . $model->pdf_file, 
                                [
                                    'target' => '_blank',
                                    'class' => 'btn btn-danger btn-lg'
                                ]) ?>
                            
                            <?= Html::a('<i class="fas fa-download"></i> Download', 
                                Yii::getAlias('@web') . '/' . $model->pdf_file, 
                                [
                                    'download' => $model->title . '.pdf',
                                    'class' => 'btn btn-outline-danger btn-lg'
                                ]) ?>
                        </div>
                        
                        <div class="mt-3 text-muted small">
                            <i class="fas fa-info-circle"></i> File: <?= basename($model->pdf_file) ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-file-excel fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No PDF Available</h5>
                            <p class="text-muted mb-3">This edition doesn't have a PDF file attached.</p>
                            <?= Html::a('<i class="fas fa-upload"></i> Upload PDF', 
                                ['update', 'id' => $model->id], 
                                ['class' => 'btn btn-primary']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?= Html::a('<i class="fas fa-edit"></i> Edit Edition', 
                            ['update', 'id' => $model->id], 
                            ['class' => 'btn btn-outline-success']) ?>
                        
                        <?= Html::a('<i class="fas fa-copy"></i> Duplicate', 
                            ['create', 'epaper_id' => $epaper->id, 'duplicate' => $model->id], 
                            ['class' => 'btn btn-outline-primary']) ?>
                        
                        <?= Html::a('<i class="fas fa-print"></i> Print Info', 
                            'javascript:window.print()', 
                            ['class' => 'btn btn-outline-secondary']) ?>
                        
                        <?= Html::a('<i class="fas fa-trash"></i> Delete', 
                            ['delete', 'id' => $model->id], 
                            [
                                'class' => 'btn btn-outline-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this edition?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                    </div>
                </div>
            </div>
            
            <!-- Status Management -->
            <div class="card mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-toggle-on"></i> Status Management</h5>
                </div>
                <div class="card-body">
                    <div class="btn-group w-100" role="group">
                        <?php foreach (['active', 'inactive', 'draft', 'archived'] as $status): ?>
                            <?php
                            $isActive = $model->status == $status;
                            $btnClass = $isActive ? 'btn-' . [
                                'active' => 'success',
                                'inactive' => 'secondary',
                                'draft' => 'warning',
                                'archived' => 'info'
                            ][$status] : 'btn-outline-secondary';
                            ?>
                            <button type="button" class="btn btn-sm <?= $btnClass ?> status-btn" 
                                    data-status="<?= $status ?>"
                                    <?= $isActive ? 'disabled' : '' ?>>
                                <?= ucfirst($status) ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <p class="text-muted small mt-2 mb-0">Click to change status</p>
                </div>
            </div>
            
            <!-- Recent Editions -->
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Recent Editions</h5>
                </div>
                <div class="card-body">
                    <?php
                    $recentEditions = \app\models\Edition::find()
                        ->where(['epaper_id' => $epaper->id])
                        ->andWhere(['!=', 'id', $model->id])
                        ->orderBy(['date' => SORT_DESC])
                        ->limit(5)
                        ->all();
                    ?>
                    
                    <?php if ($recentEditions): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recentEditions as $edition): ?>
                                <?= Html::a(Html::encode($edition->title), 
                                    ['view', 'id' => $edition->id], 
                                    [
                                        'class' => 'list-group-item list-group-item-action' . 
                                                  ($edition->id == $model->id ? ' active' : '')
                                    ]) ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center mb-0">No other editions</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.edition-view {
    background: #f8f9fa;
    min-height: 100vh;
    padding: 20px;
}

.edition-view .page-header h1 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2c3e50;
}

.edition-view .card {
    border-radius: 8px;
    overflow: hidden;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.edition-view .info-item {
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 10px;
}

.edition-view .info-item:last-child {
    border-bottom: none;
}

.edition-view .btn-lg {
    padding: 10px 20px;
    font-weight: 600;
}

.edition-view .btn-group .btn {
    border-radius: 4px !important;
}

.edition-view .list-group-item {
    border: none;
    border-radius: 4px !important;
    margin-bottom: 5px;
    padding: 8px 12px;
    font-size: 0.9rem;
}

.edition-view .list-group-item:hover {
    background-color: #f8f9fa;
}

.edition-view .list-group-item.active {
    background-color: #e7f3ff;
    color: #1a365d;
    border-left: 3px solid #3f51b5;
}

/* Status buttons */
.status-btn {
    font-size: 0.75rem;
    padding: 4px 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .edition-view .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .edition-view .page-header .btn-group {
        margin-top: 10px;
        width: 100%;
    }
    
    .edition-view .page-header .btn-group .btn {
        flex: 1;
    }
}
</style>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status change buttons
    const statusButtons = document.querySelectorAll('.status-btn');
    statusButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const newStatus = this.dataset.status;
            if (confirm('Change status to "' + newStatus + '"? This will update the edition status.')) {
                // Send AJAX request to update status
                fetch('<?= Url::to(['edition/update-status']) ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                    },
                    body: JSON.stringify({
                        id: <?= $model->id ?>,
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update status: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update status');
                });
            }
        });
    });
    
    // Print functionality enhancement
    const printBtn = document.querySelector('a[href="javascript:window.print()"]');
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            // Add print styles
            const style = document.createElement('style');
            style.innerHTML = `
                @media print {
                    .btn-group, .card-header, .status-btn, .list-group {
                        display: none !important;
                    }
                    .card {
                        box-shadow: none !important;
                        border: 1px solid #ddd !important;
                    }
                    .page-header {
                        margin-bottom: 20px !important;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    }
});
</script>
