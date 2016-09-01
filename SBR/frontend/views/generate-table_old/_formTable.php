<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
?>
<h4 class="wizard-title">Table</h4>

<?php
$gridColumns = [
    'username',
    'email',
];

// Renders a export dropdown menu
echo ExportMenu::widget([
    //  'dataProvider' => $dataProvider,
    'columns' => $gridColumns
]);
echo GridView::widget([
    // 'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'hover' => true,
]);
?>