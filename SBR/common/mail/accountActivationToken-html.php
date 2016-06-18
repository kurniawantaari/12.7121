<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$activationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/account-activation', 'token' => $user->account_activation_token]);
?>
<div class="account-activation">
    <p>You requested for create account in Indonesian Statistical Business Register System with:
        <br/>
        username:<?= Html::encode($user->username) ?>
        <br/>
        e-mail: <?= Html::encode($user->email) ?>
            
    </p>
    
    <p>If you really wanted to create account, follow the link below to activated your account:
    </p>
    <p><?= Html::a(Html::encode($activationLink), $activationLink) ?></p>  
</div>
