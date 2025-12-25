<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Media */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="media-form box-style">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php if ($model->file_path): ?>
        <p>Current file:</p>
        <p>
            <a href="<?= $model->file_path ?>" target="_blank">
                <?= Html::encode($model->file_name) ?>
            </a>
        </p>
    <?php endif; ?>

    <?= $form->field($model, 'uploadFile')->fileInput() ?>

    <?= $form->field($model, 'status')->dropDownList([
        1 => 'Active',
        0 => 'Inactive',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Upload' : 'Update', [
            'class' => 'btn btn-success',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
