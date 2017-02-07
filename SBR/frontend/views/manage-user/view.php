<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Pengguna', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php
        if (Yii::$app->user->can('manageUsers')) {
            Html::a('Hapus', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah Anda yakin akan menghapus akun ini?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
       
        
        'attributes' => [
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
        ],
    ])
    ?>

</div>