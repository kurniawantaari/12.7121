<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\HistoryTabel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="history-tabel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jenis')->textInput() ?>

    <?= $form->field($model, 'jumlah_hits')->textInput() ?>

    <?= $form->field($model, 'flag')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
