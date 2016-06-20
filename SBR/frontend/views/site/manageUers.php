<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Manage Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-manage-users">
    <h1><?= Html::encode($this->title) ?></h1>
      <?= Html::button('Add User', ['class' => 'btn btn-primary', 'name' => 'add-user-button']) ?>
    //tabel user
</div>
