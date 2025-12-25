<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Media */

$this->title = 'Update Media: ' . $model->title;
?>

<div class="media-update">

    <div class="page-header-row">
        <div class="page-title">
            <?= Html::encode($this->title) ?>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
