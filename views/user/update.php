<?php
use yii\helpers\Html;

/** @var $model app\models\User */

$this->title = 'Update User: ' . $model->username;
?>

<div class="user-update box-style">
    <div class="page-header-row">
        <div class="page-title"><?= Html::encode($this->title) ?></div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
