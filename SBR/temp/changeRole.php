<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Manage User Role';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manage-user-role">

    <h1><?= Html::encode($this->title) ?></h1>
    <h4>Role:</h4>
    <div>
        <?php $form = ActiveForm::begin([
        'action' => ['change-role'],
        'method' => 'post',
    ]); ?>
        <?= Html::activeCheckboxList($model, 'roles', $modelRole->roles); ?>
        <?= Html::activeCheckboxList($model, 'roles', ['admin' => 'admin', 'tim sbr' => 'sbr']); ?>
        <?= $form->field($model, 'roles')->checkboxList(['admin' => 'admin', 'tim sbr' => 'sbr']); ?>
        <?= $form->field($model, 'roles')->checkboxList($modelRole->roles); ?>

        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>