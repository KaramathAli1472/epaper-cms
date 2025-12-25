<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */

$this->title = 'Featured Editions Manager';
?>
<div class="epaper-featured-edition-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('Add Featured Edition', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'header' => 'Actions',
                'contentOptions' => ['style' => 'width:120px; text-align:center;'],
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
                            'data-confirm' => 'Are you sure you want to delete this item?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
            [
                'attribute' => 'name',
                'label' => 'Title',
            ],
        ],
    ]); ?>
</div>
