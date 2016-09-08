<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchDictionary */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dictionaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?= Html::a('Create Dictionary', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'term',
            'description',
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'resizableColumns' => true,
        'bordered' => true,
        'striped' => true,
        'responsive' => true,
        'hover' => true,
    ]);
    ?>
    <?php
    Pjax::end();
    ?>
</div>
