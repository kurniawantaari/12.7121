<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Dictionary';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-dictionary">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::button('Add Term', ['class' => 'btn btn-primary', 'name' => 'add-term-button']) ?>
</div>
