<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\FeaturedCategory */

$this->title = 'Featured Category Manager';
?>
<div class="featured-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <!-- Top search + add bar (like screenshot) -->
    <div class="panel" style="margin-bottom:15px; border:none;">
        <div class="panel-body" style="padding:8px 10px;">
            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'form-inline'],
                'fieldConfig' => [
                    'template' => "{input}",
                ],
            ]); ?>

            <div class=" input-group" style="width:400px;">
                <?= Html::activeTextInput($model, 'name', [
                    'class' => 'form-control',
                    'placeholder' => 'Find category to add as featured',
                ]) ?>
                <span class="input-group-btn">
                    <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
                </span>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!-- List of featured categories -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'layout' => "{items}\n{pager}",
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
    ]) ?>

</div>
