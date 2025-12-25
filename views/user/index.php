<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Users';
?>

<div class="user-index box-style">

    <!-- Title -->
    <div class="page-title">
        <?= Html::encode($this->title) ?>
    </div>

    <!-- Card 1: New User + filters -->
    <div class="toolbar-card">
        <div class="toolbar-row">
            <div class="toolbar-left">
                <?= Html::a('New User', ['create'], ['class' => 'btn btn-primary btn-new-user']) ?>
            </div>

            <div class="toolbar-right">
                <select class="form-control toolbar-input toolbar-select">
                    <option>--All/Any--</option>
                </select>

                <select class="form-control toolbar-input toolbar-select">
                    <option>--All/Any--</option>
                </select>

                <input type="text" class="form-control toolbar-input toolbar-date" value="09 Sep 2001">
                <input type="text" class="form-control toolbar-input toolbar-date" value="25 Dec 2025">

                <input type="text" class="form-control toolbar-input toolbar-search" placeholder="Search...">

                <button class="btn btn-primary btn-toolbar">Go</button>
                <button class="btn btn-default btn-toolbar">Reset</button>
                <button class="btn btn-success btn-toolbar">Export</button>
            </div>
        </div>
    </div>

    <!-- Card 2: Bulk actions -->
    <div class="bulk-card">
        <div class="bulk-row">
            <div class="bulk-left">
                <select class="form-control bulk-select">
                    <option>-- Bulk Actions --</option>
                    <option>Delete Selected</option>
                    <option>Activate Selected</option>
                    <option>Deactivate Selected</option>
                </select>
            </div>
            <div class="bulk-right">
                <button class="btn btn-primary btn-bulk-apply">Apply</button>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary'      => false,
        'tableOptions' => [
            'class' => 'table table-striped table-hover page-table',
        ],
        'headerRowOptions' => ['class' => 'page-table-header'],
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{update} {delete}',
                'headerOptions' => ['style' => 'text-align:left;'],
                'contentOptions' => ['style' => 'text-align:left;'],
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<i class="glyphicon glyphicon-pencil"></i>', $url, [
                            'title' => Yii::t('app', 'Update'),
                            'class' => 'btn btn-xs btn-warning',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        // FIXED: Hide delete button for ID 1 & 2
                        if (in_array($model['id'], [1, 2])) {
                            return '';
                        }
                        return Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $model['id']], [
                            'title' => Yii::t('app', 'Delete'),
                            'class' => 'btn btn-xs btn-danger',
                            'data-confirm' => 'Are you sure you want to delete this user?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    }
                ],
            ],
            [
                'attribute' => 'id',
                'label' => 'ID',
                'headerOptions' => ['style' => 'text-align:left;'],
                'contentOptions' => ['style' => 'text-align:left;'],
            ],
            [
                'attribute' => 'fullname',
                'label' => 'Fullname',
                'value' => function ($model) {
                    return is_array($model)
                        ? ($model['fullname'] ?? $model['username'] ?? '')
                        : ($model->fullname ?? $model->username ?? '');
                },
                'headerOptions' => ['style' => 'text-align:left;'],
                'contentOptions' => ['style' => 'text-align:left;'],
            ],
            [
                'attribute' => 'email',
                'label' => 'Email',
                'format' => 'email',
                'value' => function ($model) {
                    return is_array($model) ? ($model['email'] ?? '') : ($model->email ?? '');
                },
                'headerOptions' => ['style' => 'text-align:left;'],
                'contentOptions' => ['style' => 'text-align:left;'],
            ],
            [
                'attribute' => 'mobile',
                'label' => 'Mobile',
                'value' => function ($model) {
                    return is_array($model) ? ($model['mobile'] ?? '') : ($model->mobile ?? '');
                },
                'headerOptions' => ['style' => 'text-align:left;'],
                'contentOptions' => ['style' => 'text-align:left;'],
            ],
            [
                'attribute' => 'role',
                'label' => 'Role',
                'value' => function ($model) {
                    return is_array($model) ? ($model['role'] ?? '') : ($model->role ?? '');
                },
                'contentOptions' => ['style' => 'text-align:left;color:#e11d48;font-weight:600;'],
                'headerOptions' => ['style' => 'text-align:left;'],
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Regt Date',
                'value' => function ($model) {
                    $value = is_array($model) ? ($model['created_at'] ?? null) : ($model->created_at ?? null);
                    if (!$value) {
                        return null;
                    }
                    return is_numeric($value)
                        ? date('F d, Y, h:i a', $value)
                        : $value;
                },
                'headerOptions' => ['style' => 'text-align:left;'],
                'contentOptions' => ['style' => 'text-align:left;'],
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => function ($model) {
                    $status = is_array($model) ? ($model['status'] ?? 0) : ($model->status ?? 0);
                    return $status == 10 ? 'ACTIVE' : 'INACTIVE';
                },
                'contentOptions' => ['style' => 'text-align:left;color:#16a34a;font-weight:600;'],
                'headerOptions' => ['style' => 'text-align:left;'],
            ],
        ],
    ]); ?>
</div>

<style>
.box-style {
    background: #ffffff;
    border-radius: 6px;
    padding: 15px 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.page-title {
    margin-bottom: 6px;
    font-size: 16px;
    font-weight: 600;
    color: #111827;
}

/* Card 1 around New User line */
.toolbar-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 10px 12px;
    margin-bottom: 12px;
}

/* Top toolbar inside card */
.toolbar-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}
.toolbar-left {
    flex-shrink: 0;
}
.toolbar-right {
    display: flex;
    align-items: center;
    gap: 8px;
    justify-content: flex-end;
    flex-wrap: nowrap;
    width: 100%;
}
.btn-new-user {
    padding: 8px 20px;
    font-size: 14px;
    border-radius: 4px;
}

/* Controls ko chhota / fixed width */
.toolbar-input {
    height: 30px;
    padding: 3px 8px;
    font-size: 12px;
}
.toolbar-select { width: 130px; }
.toolbar-date   { width: 130px; }
.toolbar-search { width: 180px; }
.btn-toolbar {
    height: 30px;
    padding: 3px 12px;
    font-size: 12px;
}

/* Card 2: Bulk actions */
.bulk-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 8px 12px;
    margin-bottom: 12px;
}
.bulk-row {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;
}
.bulk-select {
    width: 160px;
    height: 30px;
    padding: 3px 8px;
    font-size: 12px;
}
.btn-bulk-apply {
    height: 30px;
    padding: 3px 14px;
    font-size: 12px;
}

/* Table */
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
</style>
