<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Dictionary */

$this->title = $model->term;
$this->params['breadcrumbs'][] = ['label' => 'Daftar Istilah', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah Anda yakin ingin menghapus istilah ini?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
                [
                'label' => 'Istilah',
                'encodeLabel' => 'false',
                'attribute' => 'term',
            ],
                [
                'label' => 'Deskripsi',
                'encodeLabel' => 'false',
                'attribute' => 'description',
            ],
        ],
    ])
    ?>

</div>
