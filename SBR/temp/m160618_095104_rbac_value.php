<?php

use yii\db\Migration;

class m160618_095104_rbac_value extends Migration
{
    public function up()
    {
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

    }

    public function down()
    {
        echo "m160618_095104_rbac_value cannot be reverted.\n";

        return false;
    }

}
