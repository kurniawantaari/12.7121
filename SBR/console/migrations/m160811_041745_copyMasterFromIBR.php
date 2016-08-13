<?php

use yii\db\Migration;

class m160811_041745_copyMasterFromIBR extends Migration
{
    public function up()
    {
        $sql="SELECT * INTO SBR.dbo.desa FROM IBR.dbo.m_desa;"
                . "SELECT * INTO SBR.dbo.kecamatan FROM IBR.dbo.m_kecamatan;"
                . "SELECT * INTO SBR.dbo.kabupaten FROM IBR.dbo.m_kabupaten;"
                . "SELECT * INTO SBR.dbo.propinsi FROM IBR.dbo.m_propinsi;"
                . "SELECT * INTO SBR.dbo.kategori FROM IBR.dbo.m_kategori;"
                . "SELECT * INTO SBR.dbo.kbli FROM IBR.dbo.m_kbli;"
                . "SELECT * INTO SBR.dbo.statusperusahaan FROM IBR.dbo.m_kondisi;"
                . "SELECT * INTO SBR.dbo.unitstatistik FROM IBR.dbo.m_unitstatistik;"
                . "SELECT * INTO SBR.dbo.institusi FROM IBR.dbo.m_institusi;"
                . "SELECT * INTO SBR.dbo.kepemilikan FROM IBR.dbo.m_kepemilikan;"
                . "SELECT * INTO SBR.dbo.jaringanusaha FROM IBR.dbo.m_jaringanusaha;";                
      $this->execute($sql);
    }

    public function down()
    {
        echo "m160811_041745_copyMasterFromIBR cannot be reverted.\n";

        return false;
    }

   
}
