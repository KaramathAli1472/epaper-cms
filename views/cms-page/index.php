<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Page Manager';
?>

<div class="page-index box-style">

    <!-- 1) TITLE ROW -->
    <div class="page-header-row">
        <div class="page-title">
            <?= Html::encode($this->title) ?>
        </div>
    </div>

    <!-- 2) TOP WHITE BAR: CREATE + SEARCH -->
    <div class="top-bar">
        <!-- Left: Create -->
        <div class="top-bar-left">
            <?= Html::a('<i class="fa fa-plus"></i> Create', ['create'], [
                'class' => 'btn btn-primary btn-create',
            ]) ?>
        </div>

        <!-- Right: Search + Go + Reset -->
        <div class="top-bar-right">
            <form method="get" class="form-inline">
                <div class="input-group input-group-sm">
                    <input type="text"
                           name="q"
                           class="form-control"
                           placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Go</button>
                    </span>
                    <span class="input-group-btn">
                        <a href="<?= Yii::$app->request->url ?>" class="btn btn-default">Reset</a>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <!-- 3) TABLE -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'tableOptions' => [
            'class' => 'table table-striped table-hover page-table',
        ],
        'headerRowOptions' => ['class' => 'page-table-header'],
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'header' => 'Actions',
                'headerOptions' => [
                    'style' => 'width: 15%;',
                    'class' => 'text-left',
                ],
                'contentOptions' => [
                    'style' => 'width: 15%;',
                    'class' => 'text-left',
                ],
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-pencil"></i>', $url, [
                            'class' => 'btn btn-xs btn-icon btn-edit',
                            'title' => 'Edit',
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'class' => 'btn btn-xs btn-icon btn-delete',
                            'title' => 'Delete',
                            'data-confirm' => 'Delete this page?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
            [
                'attribute' => 'title',
                'label' => 'Page Title',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->title, ['view', 'id' => $model->id], [
                        'title' => 'View this page',
                    ]);
                },
                'headerOptions' => [
                    'style' => 'width: 70%;',
                    'class' => 'text-left',
                ],
                'contentOptions' => [
                    'style' => 'width: 70%; text-align:left;',
                    'class' => 'text-left',
                ],
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status) {
                        return '<span class="badge badge-status badge-public">PUBLIC</span>';
                    }
                    return '<span class="badge badge-status badge-private">PRIVATE</span>';
                },
                'headerOptions' => [
                    'style' => 'width: 15%;',
                    'class' => 'text-center',
                ],
                'contentOptions' => [
                    'style' => 'width: 15%;',
                    'class' => 'text-center',
                ],
            ],
        ],
    ]); ?>
</div>

<?php
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
?>

<style>
.page-index {
    background: #f3f4f6;
    padding: 20px;
}

.box-style {
    background: #ffffff;
    border-radius: 6px;
    padding: 15px 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}

/* 1) Title row */
.page-header-row {
    margin-bottom: 8px;
}

.page-title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
}

/* 2) Top bar (Create + Search) */
.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.top-bar-right {
    min-width: 260px;
}

/* Create button */
.btn-create {
    background: #2563eb;
    border-color: #2563eb;
    padding: 6px 18px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 4px;
}

.btn-create i {
    margin-right: 4px;
}

.btn-create:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
}

/* Search input + buttons */
.top-bar .input-group .form-control {
    height: 30px;
    font-size: 13px;
}

.top-bar .btn.btn-default {
    height: 30px;
    line-height: 1;
    font-size: 12px;
    padding: 0 10px;
}

/* Table */
.page-table {
    margin-bottom: 0;
    background: #ffffff;
    border-radius: 4px;
    overflow: hidden;
}

.page-table-header > th {
    background: #f5f3ff !important;
    font-size: 13px;
    font-weight: 600;
    color: #4b5563;
    border-bottom: 1px solid #e5e7eb !important;
}

.page-table > tbody > tr > td {
    vertical-align: middle !important;
    font-size: 13px;
    border-top: 1px solid #e5e7eb;
}

.page-table > tbody > tr:hover {
    background-color: #f9fafb;
}

/* Page Title force left */
.page-table th:nth-child(2),
.page-table td:nth-child(2) {
    text-align: left !important;
}

/* Action buttons */
.btn-icon {
    padding: 4px 7px;
    border-radius: 4px;
    color: #ffffff !important;
}

.btn-edit {
    background: #10b981;
    border-color: #10b981;
}

.btn-delete {
    background: #ef4444;
    border-color: #ef4444;
}

.btn-edit:hover {
    background: #059669;
    border-color: #059669;
}

.btn-delete:hover {
    background: #dc2626;
    border-color: #dc2626;
}

/* Status badges */
.badge-status {
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 9999px;
}

.badge-public {
    background: #d1fae5;
    color: #047857;
}

.badge-private {
    background: #fee2e2;
    color: #b91c1c;
}
</style>
