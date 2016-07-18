<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <div class="panel-group" id="user-profile" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingUsername">
                <a role="button" data-toggle="collapse" data-parent="#user-profile" href="#collapseUsername" aria-expanded="false" aria-controls="collapseUsername">
                    <h4 class="panel-title"><b>Username:</b><i class="col-sm-offset-1"><?php echo $model->getOldAttribute("username"); ?></i>
                    </h4>  
                </a>
            </div>
            <div id="collapseUsername" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingUsername">
                <div class="panel-body">
                    <?php $formUsername = ActiveForm::begin(); ?>   
                    <?= $formUsername->field($model, 'username')->textInput(['style' => 'width:300px;']) ?>
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>                    
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingEmail">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#user-profile" href="#collapseEmail" aria-expanded="false" aria-controls="collapseEmail">
                    <h4 class="panel-title">
                        <b>E-mail:</b><i class="col-sm-offset-1"><?php echo $model->getOldAttribute("email"); ?></i>
                    </h4>          
                </a>
            </div>
            <div id="collapseEmail" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEmail">
                <div class="panel-body">
                    <?php $formEmail = ActiveForm::begin(); ?>  
                    <?= $formEmail->field($model, 'email') ?>
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>                    
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
                     <?= Html::a('Change your password?', ['manage-user/change-password']) ?>
                    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingStatus">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#user-profile" href="#collapseStatus" aria-expanded="false" aria-controls="collapseStatus">
                    <h4 class="panel-title">
                        <b>Status</b><i class="col-sm-offset-1"><?php echo $model->getStatusLabel(); ?></i>
                    </h4>
                </a>
            </div>
            <div id="collapseStatus" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingStatus">
                <div class="panel-body">
                    <?php $formStatus = ActiveForm::begin(); ?>  
                    <?= $formStatus->field($model, 'status')->dropDownList([0 => 'Deleted', 5 => 'Nonactive', 10 => 'Active']) ?>
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>   
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <?php
        if (Yii::$app->user->can('manageUsers')) {
            echo '<div class="panel panel-default">';
            echo '<div class="panel-heading" role="tab" id="headingRole">';
            echo '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#user-profile" href="#collapseRole" aria-expanded="false" aria-controls="collapseRole">';
            echo '<h4 class="panel-title">';
            echo '<b>Role:</b>';
            echo '</h4>';
            echo '</a>';
            echo '</div>';
            echo '<div id="collapseRole" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingRole">';
        echo '<div class="panel-body">';}?>
         <?php if (Yii::$app->user->can('manageUsers')) {}
            $formRole = ActiveForm::begin();
            $formRole->field($model, 'roles')->checkboxList(['admin' => 'admin', 'tim sbr' => 'sbr']);
            echo '<div class="form-group">';
            Html::submitButton('Update', ['class' => 'btn btn-primary']);
            echo '</div>';?>
           <?php ActiveForm::end(); ?>
           <?php 
           if (Yii::$app->user->can('manageUsers')) {
               echo '</div>';
            echo '</div>';
            echo '</div>';
           }
        
        ?>
    </div>
</div>