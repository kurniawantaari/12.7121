<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\HistoryTabel */

$this->title = 'Update History Tabel: ' . $model->idtabel;
$this->params['breadcrumbs'][] = ['label' => 'History Tabels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idtabel, 'url' => ['view', 'id' => $model->idtabel]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="history-tabel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
