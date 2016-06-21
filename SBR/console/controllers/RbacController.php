<?php

namespace console\controllers;
//namespace app\commands;

use Yii;
use yii\console\Controller;
use common\models\User;

class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;
       //add permission
        $manageGivenTable = $auth->createPermission('manageGivenTable');
        $manageGivenTable->description = 'Manage and Generate Given Table ';
        $auth->add($manageGivenTable);

        //add permission
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Manage users';
        $auth->add($manageUsers);

        //add role. dan ngasih tahu kalau yang tergabung di sbr dapat memanage given tabel
        $sbr = $auth->createRole('sbr');
        $sbr->description = 'Tim SBR BPS HQ';
        $auth->add($sbr);
        $auth->addChild($sbr, $manageGivenTable);

        //add role dan ngasih tahu kalau admin dapat memanage user dan sekaligus mewarisi sifat-sifat sbr
        $admin = $auth->createRole('admin');
        $admin->description = 'Web Administrator, Editor, and Developer';
        $auth->add($admin);
        $auth->addChild($admin, $sbr);
        $auth->addChild($admin, $manageUsers);
        
                //assign default role. first one to signp is admin and second one is sbr team
        //$auth->assign($admin, 1);
        //$auth->assign($sbr, 2);
    }
    public function actionAssign($role, $username) {
       //$user = User::find()->where(['username' => $username])->one();
        $user=User::findOne(['username' =>$username]);
        if (!$user) {
            throw new InvalidParamException("There is no user \"$username\".");
        }

        $auth = Yii::$app->authManager;
        $asrole = $auth->getRole($role);
        if (!$asrole) {
            throw new InvalidParamException("There is no role \"$role\".");
        }

        $auth->assign($asrole, $user->id);
            }
}
