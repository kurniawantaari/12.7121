<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$activationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activate-account', 'token' => $user->account_activation_token]);
?>
You requested for create account in Indonesian Statistical Business Register System with
username: <?= $user->username ?>
e-mail: <?= $user->email?>
If you really wanted to create account, follow the link below to activated your account:

<?= $activationLink ?>
