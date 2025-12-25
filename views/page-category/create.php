<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EpaperPageCategory */

$this->title = $model->isNewRecord ? 'Create Page Category' : 'Edit Page Category';
?>
<div class="epaper-page-category-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
