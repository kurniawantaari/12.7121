<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Table History';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-table-history">
    <h1><?= Html::encode($this->title) ?></h1>
   
     <?= Html::button('Add to Suggestion', ['class' => 'btn btn-primary', 'name' => 'add-to-suggestion-button']) ?>
     <?= Html::button('Delete Selected', ['class' => 'btn btn-primary', 'name' => 'delete-selected-button']) ?>
</div>
