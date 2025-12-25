<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Edition $model */
/** @var app\models\EpaperCategory $epaper */

$this->title = 'Edit Edition - ' . Html::encode($model->title);
$this->params['breadcrumbs'][] = ['label' => 'E-papers', 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = ['label' => $epaper->name, 'url' => ['index', 'epaper_id' => $epaper->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>

<div class="edition-update">
    <div class="page-header mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-0">Edit Edition</h1>
            <p class="text-muted mb-0"><?= Html::encode($epaper->name) ?></p>
        </div>
        <div class="btn-group">
            <?= Html::a('<i class="fas fa-eye"></i> View', 
                ['view', 'id' => $model->id], 
                ['class' => 'btn btn-info']) ?>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Back', 
                ['index', 'epaper_id' => $epaper->id], 
                ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Edit Edition Details</h5>
                </div>
                
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'id' => 'edition-update-form',
                        'options' => ['class' => 'form-horizontal'],
                    ]); ?>

                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'title', [
                                'template' => '
                                    <div class="form-group">
                                        <label class="form-label">{label}</label>
                                        {input}
                                        {error}
                                        <div class="form-text">Edition title</div>
                                    </div>'
                            ])->textInput([
                                'maxlength' => true,
                                'class' => 'form-control',
                                'placeholder' => 'Enter edition title'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'date', [
                                'template' => '
                                    <div class="form-group">
                                        <label class="form-label">{label}</label>
                                        {input}
                                        {error}
                                        <div class="form-text">Publication date</div>
                                    </div>'
                            ])->textInput([
                                'type' => 'date',
                                'class' => 'form-control',
                                'value' => $model->date ? date('Y-m-d', strtotime($model->date)) : ''
                            ]) ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'status', [
                                'template' => '
                                    <div class="form-group">
                                        <label class="form-label">{label}</label>
                                        {input}
                                        {error}
                                        <div class="form-text">Edition status</div>
                                    </div>'
                            ])->dropDownList([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'draft' => 'Draft',
                                'archived' => 'Archived'
                            ], [
                                'class' => 'form-control',
                                'prompt' => 'Select Status'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'pdf_file', [
                                'template' => '
                                    <div class="form-group">
                                        <label class="form-label">{label}</label>
                                        {input}
                                        {error}
                                        <div class="form-text">
                                            PDF file path (e.g., uploads/editions/filename.pdf)<br>
                                            <small class="text-danger">Current: ' . ($model->pdf_file ?: 'No PDF') . '</small>
                                        </div>
                                    </div>'
                            ])->textInput([
                                'maxlength' => true,
                                'class' => 'form-control',
                                'placeholder' => 'Enter PDF file path'
                            ]) ?>
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <?= $form->field($model, 'epaper_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

                    <div class="form-group mt-4">
                        <?= Html::submitButton('<i class="fas fa-save"></i> Save Changes', [
                            'class' => 'btn btn-primary btn-lg',
                            'name' => 'save-button'
                        ]) ?>
                        
                        <?= Html::a('<i class="fas fa-times"></i> Cancel', 
                            ['view', 'id' => $model->id], 
                            ['class' => 'btn btn-outline-secondary btn-lg']) ?>
                            
                        <?= Html::a('<i class="fas fa-trash"></i> Delete', 
                            ['delete', 'id' => $model->id], 
                            [
                                'class' => 'btn btn-danger btn-lg',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this edition?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Edition Info</h5>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <p class="mb-2"><strong>ID:</strong> #<?= $model->id ?></p>
                        <p class="mb-2"><strong>Created:</strong> <?= date('d M Y H:i', strtotime($model->created_at)) ?></p>
                        <p class="mb-2"><strong>Updated:</strong> <?= $model->updated_at ? date('d M Y H:i', strtotime($model->updated_at)) : 'Never' ?></p>
                        <p class="mb-0"><strong>Epaper:</strong> <?= Html::encode($epaper->name) ?></p>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Version History</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <small class="text-muted">Created</small>
                                <p class="mb-0"><?= date('d M Y H:i', strtotime($model->created_at)) ?></p>
                            </div>
                        </div>
                        <?php if ($model->updated_at && $model->updated_at != $model->created_at): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <small class="text-muted">Last Updated</small>
                                <p class="mb-0"><?= date('d M Y H:i', strtotime($model->updated_at)) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-lightbulb"></i> Editing Tips</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning small mb-2">
                        <i class="fas fa-exclamation-triangle"></i> <strong>PDF Files:</strong><br>
                        Ensure PDF paths are correct. Use relative paths from web root.
                    </div>
                    <div class="alert alert-info small mb-0">
                        <i class="fas fa-save"></i> <strong>Auto-save:</strong><br>
                        Changes are saved immediately. No draft version is kept.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.edition-update {
    background: #f8f9fa;
    min-height: 100vh;
    padding: 20px;
}

.edition-update .page-header h1 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2c3e50;
}

.edition-update .card {
    border-radius: 8px;
    overflow: hidden;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 20px;
}

.edition-update .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
}

.edition-update .form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 10px 12px;
    font-size: 14px;
}

.edition-update .form-control:focus {
    border-color: #3f51b5;
    box-shadow: 0 0 0 0.2rem rgba(63, 81, 181, 0.25);
}

.edition-update .form-text {
    font-size: 12px;
    color: #6c757d;
    margin-top: 5px;
}

.edition-update .btn-lg {
    padding: 10px 20px;
    font-weight: 600;
    margin-right: 10px;
}

.edition-update .info-box p {
    margin-bottom: 8px;
    padding-bottom: 8px;
    border-bottom: 1px solid #f0f0f0;
}

.edition-update .info-box p:last-child {
    border-bottom: none;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline-item {
    position: relative;
    margin-bottom: 15px;
}

.timeline-marker {
    position: absolute;
    left: -20px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

.timeline-content {
    padding-left: 5px;
}

/* Responsive */
@media (max-width: 768px) {
    .edition-update .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .edition-update .page-header .btn-group {
        margin-top: 10px;
        width: 100%;
    }
    
    .edition-update .page-header .btn-group .btn {
        flex: 1;
        margin-bottom: 5px;
    }
}
</style>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('edition-update-form');
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const title = document.getElementById('edition-title').value.trim();
        const date = document.getElementById('edition-date').value;
        
        if (!title) {
            e.preventDefault();
            alert('Please enter edition title.');
            return false;
        }
        
        if (!date) {
            e.preventDefault();
            alert('Please select publication date.');
            return false;
        }
        
        return true;
    });
    
    // Date validation
    const dateInput = document.getElementById('edition-date');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.max = today; // Can't select future dates
        
        // Add date picker enhancement
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            
            if (selectedDate > today) {
                alert('Publication date cannot be in the future.');
                this.value = today.toISOString().split('T')[0];
            }
        });
    }
    
    // Auto-save indicator
    let isChanged = false;
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            isChanged = true;
            document.title = '* ' + document.title;
        });
    });
    
    // Warn before leaving if unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (isChanged) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
            return e.returnValue;
        }
    });
    
    // Reset change flag on submit
    form.addEventListener('submit', function() {
        isChanged = false;
    });
});
</script>
