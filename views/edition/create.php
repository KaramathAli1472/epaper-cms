<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Edition */
/* @var $epaper app\models\EpaperCategory */

$this->title = 'Create New Edition - ' . $epaper->title;
$this->params['breadcrumbs'][] = ['label' => 'Edition Manager', 'url' => ['index', 'epaper_id' => $epaper->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="edition-create">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'epaper' => $epaper,
            ]) ?>
        </div>
    </div>
</div>
