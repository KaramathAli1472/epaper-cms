<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Edition */
/* @var $epaper app\models\EpaperCategory */
?>

<div class="edition-form">

    <?php $form = ActiveForm::begin([
        'id'     => 'edition-form',
        'action' => ['edition/create', 'epaper_id' => $model->epaper_id],
    ]); ?>

    <div class="row mb-3">
        <div class="col-md-6">
            <?= $form->field($model, 'title')
                ->textInput([
                    'maxlength'   => true,
                    'placeholder' => 'Edition Title',
                    'id' => 'edition-title',
                    'onblur' => 'generateAlias()'
                ])
                ->label('Edition Title') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'alias')
                ->textInput([
                    'maxlength'   => true,
                    'placeholder' => 'url-alias',
                    'id' => 'edition-alias',
                    'readonly' => true // Make it read-only if auto-generated
                ])
                ->label('URL Alias')
                ->hint('Auto-generated from title') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'category')
                ->dropDownList($model->getCategoryOptions(), [
                    'prompt' => 'Select Category',
                    'class' => 'form-control'
                ])
                ->label('Category') ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <?= $form->field($model, 'date')
                ->input('date')
                ->label('Epaper Date') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'code')
                ->textInput([
                    'maxlength'   => true,
                    'placeholder' => 'Auto-generated code',
                    'readonly'    => true,
                    'value'       => $model->code ?: 'Will be auto-generated'
                ])
                ->label('Edition Code')
                ->hint('Unique identifier for this edition') ?>
        </div>
    </div>

    <?= $form->field($model, 'description')
        ->textarea([
            'rows'        => 3,
            'placeholder' => 'Short description',
        ])
        ->label('Description') ?>

    <?= $form->field($model, 'epaper_id')
        ->hiddenInput()
        ->label(false) ?>

    <hr>

    <div class="text-end">
        <?= Html::submitButton('Schedule', [
            'class' => 'btn btn-warning',
            'name'  => 'btn-schedule',
        ]) ?>
        <?= Html::submitButton('Save Privately', [
            'class' => 'btn btn-danger',
            'name'  => 'btn-private',
        ]) ?>
        <?= Html::submitButton('Publish Now', [
            'class' => 'btn btn-success',
            'name'  => 'btn-publish',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
    console.log('Edition form loaded');
    
    // Debug button clicks
    $('button[name=\"btn-publish\"]').on('click', function() {
        console.log('🎯 Publish button CLICKED!');
        console.log('Button name:', this.name);
    });
    
    // Debug form submission
    $('#edition-form').on('submit', function(e) {
        console.log('📝 Form submitting...');
        
        // Check which button was clicked
        var submitter = e.originalEvent.submitter;
        if (submitter) {
            console.log('Submitter button:', submitter.name);
        }
    });
");
?>

<script>
function generateAlias() {
    var title = document.getElementById('edition-title').value;
    var aliasField = document.getElementById('edition-alias');
    
    if (title && !aliasField.value) {
        // Convert to lowercase
        var alias = title.toLowerCase();
        
        // Replace spaces with hyphens
        alias = alias.replace(/\s+/g, '-');
        
        // Remove special characters except hyphens
        alias = alias.replace(/[^a-z0-9\-]/g, '');
        
        // Remove multiple hyphens
        alias = alias.replace(/-+/g, '-');
        
        // Trim hyphens from start and end
        alias = alias.replace(/^-+|-+$/g, '');
        
        aliasField.value = alias;
    }
}

// Auto-generate on page load if title exists
document.addEventListener('DOMContentLoaded', function() {
    generateAlias();
    console.log('Edition form ready');
});
</script>