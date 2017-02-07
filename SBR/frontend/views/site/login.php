<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Masuk';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Isi data berikut untuk masuk:</p>

    <div class="row">
        <div class="col-lg-6">
                          
 <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>           

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    Lupa password? Silakan <?= Html::a('reset password', ['site/request-password-reset']) ?> Anda.
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Masuk', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="well col-lg-6">
                <p>*Untuk evaluasi, Anda dapat login dengan menggunakan username dan password berikut.</p>
            <p>*Sebagai admin: username=admin, password=adminmin</p>
            <p>*Sebagai tim sbr: username=sbr, password=sbrsbr</p>
            <p>*Sebagai pengguna umum: username=user, password=userser</p>
            </div>
    </div>
</div>
