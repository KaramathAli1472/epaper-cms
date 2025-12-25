<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\bootstrap5\Modal;      // Bootstrap 5 modal
use app\models\Page;

/* @var $this yii\web\View */

$this->title = 'Page Manager';
?>
<div class="page-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Page', ['create'], [
            'class' => 'btn btn-success',
            'id'    => 'btn-add-page',   // JS ke liye
        ]) ?>
    </p>

<?php
try {
    $dataProvider = new ActiveDataProvider([
        'query' => Page::find()->orderBy(['page_no' => SORT_ASC]),
        'pagination' => ['pageSize' => 20],
    ]);
} catch (InvalidConfigException $e) {
    $dataProvider = new ArrayDataProvider([
        'allModels' => [],
        'pagination' => false,
    ]);
}

// Ajax load ke liye URL
$createUrl = Url::to(['create']);
?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'header' => 'Actions',
                'contentOptions' => ['style' => 'width:160px; text-align:center;'],
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'class' => 'btn btn-xs btn-info',
                            'title' => 'View',
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function($url, $model) {
                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                            'class' => 'btn btn-xs btn-primary',
                            'title' => 'Edit',
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                            'class' => 'btn btn-xs btn-danger',
                            'title' => 'Delete',
                            'data-confirm' => 'Are you sure you want to delete this item?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
            [
                'attribute' => 'title',
                'label' => 'Page Title',
                'contentOptions' => ['style' => 'vertical-align:middle;'],
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'raw',
                'value' => function($model) {
                    return ((int)$model->status === 1)
                        ? '<span class="btn btn-xs btn-success">PUBLIC</span>'
                        : '<span class="btn btn-xs btn-secondary">PRIVATE</span>';
                },
                'contentOptions' => ['style' => 'text-align:center; width:110px;'],
            ],
        ],
    ]); ?>
</div>

<?php
// ---- Bootstrap 5 Modal for Create form ----

Modal::begin([
    'id' => 'page-modal',
    'title' => 'Add Page',
    'size' => Modal::SIZE_LARGE,
]);

echo '<div id="page-modal-content"></div>';

Modal::end();

// JS: Add Page button → modal + Ajax load
$js = <<<JS
$('#btn-add-page').on('click', function(e) {
    e.preventDefault();
    var modal = $('#page-modal');
    modal.modal('show');
    modal.find('#page-modal-content').load('$createUrl');
});
JS;

$this->registerJs($js);

// FontAwesome (agar global assets me nahi hai to)
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
?>
