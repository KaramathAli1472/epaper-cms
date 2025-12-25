<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */

$this->title = 'Page Categories';
?>
<div class="epaper-page-category-index">
    <div class="row">
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-4 text-right">
            <p><?= Html::a('Add Page Category', ['create'], ['class' => 'btn btn-success']) ?></p>
        </div>
    </div>

    <?php Pjax::begin(['id' => 'page-category-grid-pjax']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered table-striped table-hover'],
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'width:120px; text-align:center;'],
                'contentOptions' => ['style' => 'text-align:center;'],
                'buttons' => [
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
                            'data-confirm' => 'Are you sure you want to delete this category?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
            [
    'attribute' => 'name',
    'label' => 'Title',
    'headerOptions' => ['style' => 'text-align: left;'],  // ✅ Header bhi left align
    'contentOptions' => [
        'style' => 'font-weight:500; text-align: left;'  // ✅ Content bhi left align
    ],
],
            
            
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$css = <<<CSS
.epaper-page-category-index .table > thead > tr > th {
    background-color: #f5f5f5;
    font-weight: bold;
    text-align: center;
    border: 1px solid #ddd;
}
.epaper-page-category-index .table > tbody > tr > td {
    padding: 12px 8px;
    vertical-align: middle;
}
CSS;
$this->registerCss($css);
?>
