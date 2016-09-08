<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\HistoryTabelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="history-tabel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idtabel') ?>

    <?= $form->field($model, 'nmtabel') ?>

    <?= $form->field($model, 'jenis') ?>

    <?= $form->field($model, 'variabelvertikal') ?>

    <?= $form->field($model, 'variabelhorizontal') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
