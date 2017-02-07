<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchDictionary */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Istilah';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Buat Istilah', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
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
              
            [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view} {update} {delete}',
    'buttons' => [
        'delete' => function($url, $model){
            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                'class' => '',
                'data' => [
                    'confirm' => 'Apakah Anda yakin ingin menghapus istilah ini?.',
                    'method' => 'post',
                ],
            ]);
        }
    ]
],
        ],
        'resizableColumns' => true,
        'bordered' => true,
        'striped' => true,
        'responsive' => true,
        'hover' => true,
    ]);
    ?>
    <?php
    Pjax::end();
    ?>
</div>
