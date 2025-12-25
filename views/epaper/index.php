<?php

/** @var yii\web\View $this */
/** @var app\models\Epaper[] $epapers */

use yii\helpers\Html;

$this->title = 'Epaper Archive';
?>
<div class="container mt-4">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (empty($epapers)): ?>
        <p>No editions found. Please insert some records into the <code>epaper</code> table.</p>
    <?php else: ?>
        <table class="table table-bordered table-striped mt-3">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Edition Date</th>
                <th>PDF</th>
                <th>Thumbnail</th>
                <th>Category</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($epapers as $e): ?>
                <tr>
                    <td><?= Html::encode($e->id) ?></td>
                    <td><?= Html::encode($e->title) ?></td>
                    <td><?= Html::encode($e->edition_date) ?></td>
                    <td>
                        <?php if ($e->pdf_path): ?>
                            <a href="<?= Html::encode($e->pdf_path) ?>" target="_blank">View PDF</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($e->thumbnail): ?>
                            <img src="<?= Html::encode($e->thumbnail) ?>" alt="thumb" style="height:60px;">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?= Html::encode($e->category) ?></td>
                    <td><?= Html::encode($e->status) ?></td>
                    <td><?= Html::encode($e->created_at) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

