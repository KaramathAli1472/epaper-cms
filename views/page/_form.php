<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
?>

<div class="page-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Page Title') ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true])->label('Alias') ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 8, 'id' => 'page-content'])->label('Content') ?>

    <?php
    // Load CKEditor from CDN and initialize on the textarea with id 'page-content'
    $this->registerJsFile('https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::class]]);
    $this->registerJs("if (typeof CKEDITOR !== 'undefined') { CKEDITOR.replace('page-content', {height: 300}); }");
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancel', ['index', 'edition_id' => $model->edition_id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
