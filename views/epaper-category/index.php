<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Category Manager';
$models = $dataProvider->models;
?>
<div class="epaper-category-index">

    <div class="page-header mb-3">
    <h4 class="mb-2"><?= Html::encode($this->title) ?></h4>

    <?= Html::a(
        'New Category',
        ['create'],
        ['class' => 'btn btn-success btn-sm']
    ) ?>
</div>

    <div class="card">
        <div class="card-header">Category List</div>

        <div class="card-body p-2">

            <?php if (!empty($models)): ?>
                <?php foreach ($models as $model): ?>
                    <div class="cat-row">

                        <!-- LEFT : Edit / Delete / Publish -->
                        <div class="cat-actions-left">
                            <a href="<?= Url::to(['update', 'id' => $model->id]) ?>"
                               class="cat-btn cat-btn-edit"
                               title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <a href="<?= Url::to(['delete', 'id' => $model->id]) ?>"
                               class="cat-btn cat-btn-delete"
                               data-method="post"
                               data-confirm="Delete this category?"
                               title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>

                            <a href="javascript:void(0)"
                               class="cat-btn cat-btn-add publish-btn"
                               data-id="<?= $model->id ?>"
                               title="Publish / Unpublish">
                                <?php if ($model->is_published): ?>
                                    <i class="fas fa-minus"></i>
                                <?php else: ?>
                                    <i class="fas fa-plus"></i>
                                <?php endif; ?>
                            </a>
                        </div>

                        <!-- CENTER : Name -->
                        <div class="cat-name">
                            <?= Html::encode($model->name) ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted mb-0">No categories found.</p>
            <?php endif; ?>

        </div>
    </div>
</div>

<!-- STYLES -->
<style>
.cat-row {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    padding: 6px;
    background: #fff;
    margin-bottom: 4px;
}

.cat-row:hover {
    background: #f7f7f7;
}

.cat-actions-left {
    display: flex;
}

.cat-name {
    flex: 1;
    padding: 0 8px;
    font-weight: 500;
}

/* Square Buttons */
.cat-btn {
    width: 30px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 3px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
}

.cat-btn-add {
    background: #4caf50; /* Publish */
}

.cat-btn-edit {
    background: #009688;
}

.cat-btn-delete {
    background: #e91e63;
}

.cat-btn:hover {
    opacity: 0.85;
}
</style>

<?php
/* =========================
   PUBLISH / UNPUBLISH JS
   ========================= */
$toggleUrl = Url::to(['epaper-category/toggle-publish']);

$js = <<<JS
document.querySelectorAll('.publish-btn').forEach(function(btn) {
    btn.addEventListener('click', function () {

        let id = this.dataset.id;
        let icon = this.querySelector('i');

        fetch('$toggleUrl', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-Token': yii.getCsrfToken()
            },
            body: 'id=' + id
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (data.status == 1) {
                    icon.className = 'fas fa-minus';
                } else {
                    icon.className = 'fas fa-plus';
                }
            }
        });
    });
});
JS;

$this->registerJs($js);
?>