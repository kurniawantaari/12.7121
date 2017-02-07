<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

use kartik\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Daftar Istilah';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-daftaristilah">
    <h1><?= Html::encode($this->title) ?></h1>
   
    <div class="container">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
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
        'bordered' => true,
        'striped' => true,
        'responsive' => true,
        'hover' => true,
        'resizableColumns' => true,
    ]); ?>
<?php Pjax::end(); ?>
    </div>
</div>