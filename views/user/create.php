<?php
use yii\helpers\Html;

/** @var $model stdClass */

$isNew = empty($model->id);
$this->title = $isNew ? 'New User' : 'Edit User';
?>

<div class="user-create box-style">

    <div class="page-title">
        <?= Html::encode($this->title) ?>
    </div>

    <div class="form-card">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
