<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\AccountActivationForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Account Activation';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-account-activation">
    <h1><?= Html::encode($this->title) ?></h1>

        <div class="row">
        <div class="col-lg-5">
            <p>Click the button below to activate your account!</p>
            <?php $form = ActiveForm::begin(['id' => 'account-activation-form']); ?>

                  <div class="form-group">
                    <?= Html::submitButton('Activate', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
