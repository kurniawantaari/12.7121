<?php

namespace console\controllers;
//namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller {

//    public function actionInit() {
//        if (!$this->confirm("Are you sure? It will re-create permissions tree.")) {
//            return self::EXIT_CODE_NORMAL;
//        }
//        $auth = Yii::$app->authManager;
//        $auth->removeAll();
//        //add permission
//        $manageGivenTable = $auth->createPermission('manageGivenTable');
//        $manageGivenTable->description = 'Manage and Generate Given Table ';
//        $auth->add($manageGivenTable);
//
//        //add permission
//        $manageUsers = $auth->createPermission('manageUsers');
//        $manageUsers->description = 'Manage users';
//        $auth->add($manageUsers);
//
//        //add role. dan ngasih tahu kalau yang tergabung di sbr dapat memanage given tabel
//        $sbr = $auth->createRole('sbr');
//        $sbr->description = 'Tim SBR BPS HQ';
//        $auth->add($sbr);
//        $auth->addChild($sbr, $manageGivenTable);
//
//        //add role dan ngasih tahu kalau admin dapat memanage user dan sekaligus mewarisi sifat-sifat sbr
//        $admin = $auth->createRole('admin');
//        $admin->description = 'Web Administrator, Editor, and Developer';
//        $auth->add($admin);
//        $auth->addChild($admin, $sbr);
//        $auth->addChild($admin, $manageUsers);
//    }

//    public function actionDefaultassign() {
//        $auth = Yii::$app->authManager;
//        $auth->assign(admin, 1);
//        $auth->assign(sbr, 3);
//    }

    public function actionAssign($role, $username) {
       $user = User::find()->where(['username' => $username])->one();
       // $user=User::findOne(['username' =>$username])->id;
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
