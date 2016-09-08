<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Result Table';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="container">   
    
        <?= Html::a('New Custom Table', ['/generate-table/generate-custom-table'], ['class' => 'btn btn-primary']) ?>
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
        'export' => ['fontAwesome' => true,],
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
$this->registerJs("
       $('table').dragtable();
");

    ?>
</div>