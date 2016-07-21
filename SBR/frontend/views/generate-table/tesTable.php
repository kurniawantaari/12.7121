<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\tabs\TabsX;
use yii\widgets\ActiveForm;

$this->title = 'Tes Table Generator';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generate-table">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php
    $form = ActiveForm::begin([
                'id' => 'table-generator-form',
                'options' => ['class' => 'form-horizontal'],
    ]);
    echo TabsX::widget([
        'items' => [
            [
                'label' => 'Step 1: Select Subject',
                'content' => $this->render('_formSelectSubject', ['model' => $model, 'form' => $form]),
                'active' => true
            ],
            [
                'label' => 'Step 2: Select Attributes and Years',
                'content' => $this->render('_formSelectAttributesandYears', ['model' => $model, 'form' => $form])
            ],
            [
                'label' => 'Step 3: Select Locations',
                'content' => $this->render('_formSelectLocations', ['model' => $model, 'form' => $form])
            ],
            [
                'label' => 'Step 4: Select Variables',
                'content' => $this->render('_formSelectVariables', ['model' => $model, 'form' => $form])
            ],
            [
                'label' => 'Step 5: Table',
                'content' => $this->render('_formTable', ['model' => $model, 'dataProvider' => $dataProvider, 'form' => $form])
            ],
            [
                'label' => 'Step 6: Chart and Map',
                'content' => $this->render('_formChartandMap', ['model' => $model, 'form' => $form])
            ],
        ],
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'bordered' => true,
        'options' => ['class' => 'nav-pills']
    ]);
    ActiveForm::end()
    ?>
</div>
