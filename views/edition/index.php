<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Edition;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $epaper app\models\EpaperCategory|null */
/* @var $pageTitle string */

$this->title = $pageTitle ?: 'Edition Manager';
?>

<div class="edition-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            'New Edition',
            Url::to(['/edition/create', 'epaper_id' => $epaper ? $epaper->id : 1]),
            ['class' => 'btn btn-success']
        ) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'columns' => [
            [
                'class'  => 'yii\grid\CheckboxColumn',
                'header' => 'Actions',
            ],
            [
                'format' => 'raw',
                'value'  => function (Edition $model) {
                    return Html::a(
                            'Upload Pages',
                            ['page/index', 'edition_id' => $model->id],
                            ['class' => 'btn btn-xs btn-primary']
                        ) . ' ' .
                        Html::a(
                            '+',
                            ['create', 'epaper_id' => $model->epaper_id],
                            ['class' => 'btn btn-xs btn-success']
                        );
                },
            ],
            'title',
            [
                'attribute' => 'date',
                'format'    => ['date', 'php:d M Y'],
            ],
            [
                'attribute' => 'category',
                'value'     => function (Edition $model) {
                    return $model->getCategoryLabel();
                },
            ],
            [
                'attribute' => 'pdf_file',
                'format'    => 'raw',
                'value'     => function (Edition $model) {
                    return $model->pdf_file
                        ? Html::a(
                            '<i class="fa fa-file-pdf-o"></i>',
                            $model->pdf_file,
                            [
                                'target' => '_blank',
                                'style'  => 'color:red;',
                            ]
                        )
                        : '';
                },
            ],
            [
                'attribute' => 'status',
                'format'    => 'raw',
                'value'     => function (Edition $model) {
                    $status = $model->status;
                    $class  = 'default';

                    if ($status === Edition::STATUS_SCHEDULED) {
                        $class = 'warning';
                    } elseif ($status === Edition::STATUS_PRIVATE) {
                        $class = 'danger';
                    } elseif ($status === Edition::STATUS_PUBLISHED || $status === Edition::STATUS_ACTIVE) {
                        $class = 'success';
                    }

                    return '<span class="label label-' . $class . '">' . ucfirst($status) . '</span>';
                },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
