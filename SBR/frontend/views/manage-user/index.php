<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pengguna';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Tambah Pengguna', ['/site/signup'], ['class' => 'btn btn-primary']) ?>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
              [
                'label' => 'Username',
                'encodeLabel' => 'false',
                'attribute' => 'username',
            ],
        [
                'label' => 'Surel',
                'encodeLabel' => 'false',
                'attribute' => 'email',
            'format'=>'email'
            ],
        [
                'label' => 'Status',
                'encodeLabel' => 'false',
                'attribute' => 'status',
            ],
                     [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view} {update} {delete}',
    'buttons' => [
        'delete' => function($url, $model){
            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                'class' => '',
                'data' => [
                    'confirm' => 'Apakah Anda yakin ingin menghapus akun ini?.',
                    'method' => 'post',
                ],
            ]);
        }
    ]
],
            
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>
