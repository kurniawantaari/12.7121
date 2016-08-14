<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\HistoryTabel */

$this->title = $model->idtabel;
$this->params['breadcrumbs'][] = ['label' => 'History Tabels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-tabel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idtabel], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idtabel], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idtabel',
            'jenis',
            'jumlah_hits',
            'flag',
        ],
    ]) ?>

</div>
