<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'account detail';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-account-detail">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="panel-group" id="user-profile" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingUsername">
                    <a role="button" data-toggle="collapse" data-parent="#user-profile" href="#collapseUsername" aria-expanded="true" aria-controls="collapseUsername">
                        <h4 class="panel-title"><b>Username:</b><i class="col-sm-offset-1">nama usernya</i>
                        </h4>  
                    </a>
                </div>
                <div id="collapseUsername" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingUsername">
                    <div class="panel-body">
                        <?php $formUsername = ActiveForm::begin(['id' => 'form-edit-username']); ?>

                        <?= $formUsername->field($modelUsername, 'username')->textInput(['style' => 'width:300px;']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save-username-button']) ?>
                            <?= Html::button('Cancel', ['class' => 'btn btn-primary', 'name' => 'cancel-username-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingEmail">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#user-profile" href="#collapseEmail" aria-expanded="false" aria-controls="collapseEmail">
                        <h4 class="panel-title">
                            <b>E-mail:</b><i class="col-sm-offset-1">example@email.com</i>
                        </h4>          
                    </a>
                </div>
                <div id="collapseEmail" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEmail">
                    <div class="panel-body">
                        <?php $formEmail = ActiveForm::begin(['id' => 'form-edit-email']); ?>

                        <?= $formEmail->field($modelEmail, 'email') ?>

                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save-email-button']) ?>
                            <?= Html::button('Cancel', ['class' => 'btn btn-primary', 'name' => 'cancel-email-button']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingPassword">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#user-profile" href="#collapsePassword" aria-expanded="false" aria-controls="collapsePassword">
                        <h4 class="panel-title">
                            <b>Password</b>
                        </h4>    
                    </a>
                </div>
                <div id="collapsePassword" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingPassword">
                    <div class="panel-body">
                        <?php $formPassword = ActiveForm::begin(['id' => 'form-edit-password']); ?>

                        <?= $formPassword->field($modelPassword, 'password')->passwordInput(['style' => 'width:300px;']) ?>
                        <?= $formPassword->field($modelPassword, 'newPassword')->passwordInput(['style' => 'width:300px;']) ?>
                        <?= $formPassword->field($modelPassword, 'confirmNewPassword')->passwordInput(['style' => 'width:300px;']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save-password-button']) ?>
                            <?= Html::button('Cancel', ['class' => 'btn btn-primary', 'name' => 'cancel-password-button']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingStatus">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#user-profile" href="#collapseStatus" aria-expanded="false" aria-controls="collapseStatus">
                        <h4 class="panel-title">
                            <b>Status</b><i class="col-sm-offset-1">active</i>
                        </h4>
                    </a>
                </div>
                <div id="collapseStatus" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingStatus">
                    <div class="panel-body">
                        <?php $formStatus= ActiveForm::begin(['id' => 'form-edit-status']); ?>

                        <?= $formStatus->field($modelStatus, 'status')->dropDownList([0=>'Deleted',5=>'Nonactive',10=>'Active'])
                             ?>

                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save-status-button']) ?>
                            <?= Html::button('Cancel', ['class' => 'btn btn-primary', 'name' => 'cancel-status-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingRole">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#user-profile" href="#collapseRole" aria-expanded="false" aria-controls="collapseRole">
                        <h4 class="panel-title">
                            <b>Role:</b><i class="col-sm-offset-1">admin</i>
                        </h4>
                    </a>
                </div>
                <div id="collapseRole" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingRole">
                    <div class="panel-body">
                       <?php $formRole= ActiveForm::begin(['id' => 'form-edit-role']); ?>

                        <?= $formRole->field($modelRole, 'role')->dropDownList(['admin'=>'admin','sbr'=>'tim SBR']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'save-role-button']) ?>
                            <?= Html::button('Cancel', ['class' => 'btn btn-primary', 'name' => 'cancel-role-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
