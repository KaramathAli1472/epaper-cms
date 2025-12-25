<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Media */

$this->title = 'Upload Media';
?>

<div class="media-create">

    <div class="page-header-row">
        <div class="page-title">
            <?= Html::encode($this->title) ?>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
