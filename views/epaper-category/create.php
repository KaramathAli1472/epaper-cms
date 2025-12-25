<?php
use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model app\models\EpaperCategory */

$this->title = 'New Category';
?>
<div class="epaper-category-create">
    <h4 class="mb-3"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

