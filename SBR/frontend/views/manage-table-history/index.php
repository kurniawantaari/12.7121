<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchTableHistory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Table Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
             ['class' => 'yii\grid\CheckboxColumn'],
            //['class' => 'yii\grid\SerialColumn'],

                     'nama_tabel',
            'jumlah_hits',
            ['class' => 'yii\grid\ActionColumn','template'=>'{view} {delete}' ],
        ],
    ]); ?>
   <?= Html::submitButton('Delete Selected', ['class' => 'btn btn-warning', 'id'=>'deleteSelected','name' => 'delete-selected-button']) ?>
    <?= Html::submitButton('Add to Suggestion', ['class' => 'btn btn-primary', 'id'=>'addToSuggestion','name' => 'add-to-suggestion-button']) ?>
   <?php Pjax::end(); ?>

<?php 

    $this->registerJs(' 

    $(document).ready(function(){
    $(\'#deleteSelected\').click(function(){

        var RowId = $(\'#w1\').yiiGridView(\'getSelectedRows\');
          $.ajax({
            type: \'POST\',
            url : \'index.php?r=manage-table-history/delete-selected\',
            data : {row_id: RowId},
            success : function() {
              $(this).closest(\'tr\').remove();
            }
        });

    });
    });', \yii\web\View::POS_READY);

?>
</div>