<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */   // ya app\models\CmsPage agar woh model use ho raha ho
/* @var $form yii\widgets\ActiveForm */

?>
<div class="page-form">

    <?php $form = ActiveForm::begin([
        'id' => 'page-form',
        'enableAjaxValidation'   => false,   // agar chahiye to true kar sakte ho
        'enableClientValidation' => true,
    ]); ?>

    <!-- Page Title -->
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <!-- Content (agar model me attribute hai to) -->
    <?php if ($model->hasAttribute('content')): ?>
        <?= $form->field($model, 'content')->textarea(['rows' => 8]) ?>
    <?php endif; ?>

    <!-- Page No readonly (agar attribute exist kare) -->
    <?php if ($model->hasAttribute('page_no')): ?>
        <?= $form->field($model, 'page_no')->textInput(['readonly' => true]) ?>
    <?php endif; ?>

    <!-- Status dropdown -->
    <?= $form->field($model, 'status')->dropDownList([
        1 => 'PUBLIC',
        0 => 'PRIVATE',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Create' : 'Update',
            ['class' => 'btn btn-success']
        ) ?>

        <!-- Modal ke andar cancel button -->
        <?= Html::button('Cancel', [
            'class' => 'btn btn-secondary ml-2',
            'data-dismiss' => 'modal',
            'type' => 'button',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
