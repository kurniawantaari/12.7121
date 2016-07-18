<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\TableHistory */

$this->title = $model->nama_tabel;
$this->params['breadcrumbs'][] = ['label' => 'Table Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-history-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nama_tabel',
            'jumlah_hits',
            'flag',
                    ],
    ])
    ?>

</div>
