<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\EpaperCategory;

/** @var $this yii\web\View */
/** @var $model app\models\EpaperCategory */
/** @var $form yii\widgets\ActiveForm */

$parents = ArrayHelper::map(
    EpaperCategory::find()->orderBy(['title' => SORT_ASC])->all(),
    'id',
    'title'
);
?>

<div class="row">
    <div class="col-md-8">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>  <!-- 👈 YE ADD KIA -->

        <?= $form->field($model, 'alias')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

        <?= $form->field($model, 'parent_id')->dropDownList(
            $parents,
            ['prompt' => '-- None --']
        ) ?>

        <div class="form-group">
            <label>Image</label><br>
            <?php if ($model->image): ?>
                <img src="/<?= $model->image ?>" style="width:120px;height:auto;border:1px solid #ddd;margin-bottom:10px;">
            <?php endif; ?>
            <?= $form->field($model, 'imageFile')->fileInput()->label(false) ?>
        </div>

        <div class="form-group mt-3">
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="col-md-4">
        <!-- right side SEO box with tabs -->
        <div class="card">
            <div class="card-header p-2">
                Search Engine Optimization
            </div>
            <div class="card-body p-2">

                <ul class="nav nav-tabs mb-2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#seo-basic" role="tab">Basic</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#seo-open-graph" role="tab">Open Graph</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#seo-twitter" role="tab">Twitter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#seo-header-footer" role="tab">Header/Footer Codes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#seo-vars" role="tab">Variables</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="seo-basic" role="tabpanel">
                        <small>Custom Title</small>
                        <input type="text" class="form-control form-control-sm mb-2">

                        <small>Meta Description</small>
                        <textarea class="form-control form-control-sm mb-2" rows="2"></textarea>

                        <small>Meta Keywords</small>
                        <input type="text" class="form-control form-control-sm mb-2">

                        <small>Robots</small>
                        <input type="text" class="form-control form-control-sm mb-2">
                    </div>

                    <div class="tab-pane fade" id="seo-open-graph" role="tabpanel">
                        <p class="small mb-0">Open Graph fields yahan baad me add kar sakte ho.</p>
                    </div>

                    <div class="tab-pane fade" id="seo-twitter" role="tabpanel">
                        <p class="small mb-0">Twitter tags yahan baad me add kar sakte ho.</p>
                    </div>

                    <div class="tab-pane fade" id="seo-header-footer" role="tabpanel">
                        <p class="small mb-0">Header/Footer codes yahan baad me add kar sakte ho.</p>
                    </div>

                    <div class="tab-pane fade" id="seo-vars" role="tabpanel">
                        <p class="small mb-0">Variables yahan baad me configure kar sakte ho.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
// title se alias auto-generate
const titleInput = document.getElementById('epapercategory-title');
const aliasInput = document.getElementById('epapercategory-alias');

if (titleInput && aliasInput) {
    titleInput.addEventListener('keyup', function() {
        let v = this.value.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        aliasInput.value = v;
    });
}
JS;

$this->registerJs($js);
?>

