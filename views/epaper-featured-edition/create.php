<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EpaperFeaturedEdition */

$this->title = $model->isNewRecord ? 'Create Featured Edition' : 'Edit Featured Edition';
?>
<div class="epaper-featured-edition-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
