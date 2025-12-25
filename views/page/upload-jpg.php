<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $edition app\models\Edition */

$this->title = 'Upload JPGs - ' . $edition->title;
?>

<div class="page-upload-jpg">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Is edition ke liye multiple JPG / PNG files select karke upload karein.</p>

    <?= Html::beginForm(
        ['page/upload-jpg', 'edition_id' => $edition->id],
        'post',
        ['enctype' => 'multipart/form-data']
    ) ?>

        <div class="form-group">
            <label>Select JPG files</label>
            <input
                type="file"
                name="files[]"
                multiple
                accept="image/jpeg,image/jpg,image/png"
                class="form-control"
            >
        </div>

        <div class="form-group" style="margin-top:15px;">
            <button type="submit" class="btn btn-success">Upload</button>

            <?= Html::a(
                'Back',
                ['page/index', 'edition_id' => $edition->id],
                ['class' => 'btn btn-default']
            ) ?>
        </div>

    <?= Html::endForm() ?>
</div>
