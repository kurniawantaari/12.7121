<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Hasil Tabel';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="container">   

    <?= Html::a('Buat Baru', ['/generate-table/generate-custom-table'], ['class' => 'btn btn-primary']) ?>
    <br>
    <br>
    <?=
    GridView::widget([
        'id' => 'result-table',
        'class' => 'col-md-12 sortable',
        'dataProvider' => $dataProvider,
        //  'columns' => $gridColumns,
        'resizableColumns' => true,
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'toolbar' => ['{export}',],
        
        
        'export' => ['fontAwesome' => true,
            'icon' => true,
            'label' => '<span class="glyphicon glyphicon-download-alt"></span>',
        ],
        'bordered' => true,
        'striped' => true,
        'responsive' => true,
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => $judultabel,
            'footer' => '* Resize table columns just like a spreadsheet by dragging the column edges.<br>* Change column order by drag and drop column header.',
        ],
        'summary' => '',
    ])
    ?>
    <?php
//testing only
//print_r($tsql);
    $this->registerJs("
       $('table').dragtable();
       
");

    $this->registerJsFile('@web/js/sorttable.js');
    ?>
</div>