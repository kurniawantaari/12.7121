<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\HistoryTabel */

$this->title = 'Create History Tabel';
$this->params['breadcrumbs'][] = ['label' => 'History Tabels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-tabel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
