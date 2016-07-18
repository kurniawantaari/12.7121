<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Tes Table';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generate-table">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $gridColumns = [
        'harga',
        'buah',
        'jumlah',
    ];

// Renders a export dropdown menu
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'hover' => true,
           ]);
    ?>
</div>
