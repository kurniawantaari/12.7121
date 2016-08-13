<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\tabs\TabsX;

$this->title = 'Result Table';
$this->params['breadcrumbs'][] = $this->title;
//kasih button buat kembali ke generate table
?>
    <h1><?= Html::encode($this->title) ?></h1>
    ini hasilnya




    <?php
    echo TabsX::widget([
        'items' => [
            [
                'label' => 'Table',
                'content' => $this->render('_formTable'
                    //'dataProvider' => $dataProvider, 
                    )
            ],
            [
                'label' => 'Chart and Map',
                'content' => $this->render('_formChartandMap')
            ],
        ],
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'bordered' => true,
        'options' => ['class' => 'nav-pills']
    ]);
    