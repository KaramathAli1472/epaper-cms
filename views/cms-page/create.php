<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CmsPage */

$this->title = 'Create New Page';
?>
<div class="cms-page-create">

    <h1 style="color: #2c3e50; font-size: 24px; margin-bottom: 25px; font-weight: 600;"><?= Html::encode($this->title) ?></h1>

    <div class="cms-page-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title', [
            'labelOptions' => ['class' => 'control-label', 'style' => 'font-weight: 500; color: #495057;']
        ])->textInput([
            'maxlength' => true,
            'class' => 'form-control',
            'placeholder' => 'Enter page title'
        ]) ?>

        <?= $form->field($model, 'content', [
            'labelOptions' => ['class' => 'control-label', 'style' => 'font-weight: 500; color: #495057;']
        ])->textarea([
            'rows' => 8,
            'class' => 'form-control',
            'placeholder' => 'Enter page content here...'
        ]) ?>

        <?= $form->field($model, 'status', [
            'labelOptions' => ['class' => 'control-label', 'style' => 'font-weight: 500; color: #495057;']
        ])->dropDownList([
            1 => 'PUBLIC',
            0 => 'PRIVATE',
        ], [
            'class' => 'form-control',
            'prompt' => 'Select status'
        ]) ?>

        <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eaeaea;">
            <?= Html::submitButton('Save', [
                'class' => 'btn btn-primary',
                'style' => 'padding: 8px 20px; font-size: 14px; font-weight: 500; border-radius: 4px; margin-right: 10px;'
            ]) ?>
            <?= Html::a('Cancel', ['index'], [
                'class' => 'btn btn-outline-secondary',
                'style' => 'padding: 8px 20px; font-size: 14px; font-weight: 500; border-radius: 4px;'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<style>
/* Main container */
.cms-page-create {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

/* Form styling - Clean and professional */
.cms-page-form {
    background-color: #fff;
    padding: 25px 30px;
    border-radius: 8px;
    border: 1px solid #e1e5eb;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Form groups */
.cms-page-form .form-group {
    margin-bottom: 25px;
}

/* Input fields */
.cms-page-form .form-control {
    border: 1px solid #d1d5db;
    border-radius: 4px;
    padding: 10px 12px;
    font-size: 14px;
    color: #374151;
    transition: all 0.2s ease;
    background-color: #fff;
}

.cms-page-form .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
}

/* Labels */
.cms-page-form label.control-label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
}

/* Textarea specific */
.cms-page-form textarea.form-control {
    resize: vertical;
    min-height: 200px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    line-height: 1.5;
}

/* Select dropdown */
.cms-page-form select.form-control {
    height: 42px;
    cursor: pointer;
}

/* Save Button - Professional style */
.cms-page-create .btn-primary {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
    transition: all 0.2s ease;
}

.cms-page-create .btn-primary:hover {
    background-color: #2563eb;
    border-color: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
}

.cms-page-create .btn-primary:active {
    transform: translateY(0);
}

/* Cancel Button - Professional style */
.cms-page-create .btn-outline-secondary {
    color: #6b7280;
    border-color: #d1d5db;
    background-color: transparent;
    transition: all 0.2s ease;
}

.cms-page-create .btn-outline-secondary:hover {
    background-color: #f9fafb;
    color: #374151;
    border-color: #9ca3af;
    transform: translateY(-1px);
}

/* Form group actions */
.cms-page-form .form-group:last-child {
    margin-bottom: 0;
    text-align: right;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .cms-page-create {
        padding: 15px;
    }
    
    .cms-page-form {
        padding: 20px;
    }
    
    .cms-page-form .form-group:last-child {
        text-align: center;
    }
    
    .cms-page-form .btn {
        display: block;
        width: 100%;
        margin-bottom: 10px;
        margin-right: 0;
    }
}
</style>