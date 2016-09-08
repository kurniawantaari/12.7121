<?php

namespace frontend\models;

use yii\base\Model;
use frontend\models\HistoryTabel;
use frontend\models\HistoryAttributes;
use frontend\models\HistoryInstitusi;
use frontend\models\HistoryJaringanusaha;
use frontend\models\HistoryKdkategori;
use frontend\models\HistoryKdkbli;
use frontend\models\HistoryKepemilikan;
use frontend\models\HistoryLokasi;
use frontend\models\HistoryStatusperusahaan;
use frontend\models\HistoryTahun;
use frontend\models\HistoryUnitstatistik;
use yii\data\SqlDataProvider;

/**
 * Generator Table Form is the model behind the generator table.
 */
class GeneratorTableForm extends Model {

    public $subject;
    public $vvertikal;
    public $vhorizontal;
    public $attributes;
    public $years;
    public $kdprop;
    public $kdkab;
    public $kdkec;
    public $kddesa;
    public $kdkategori;
    public $kdkbli;
    public $unitstatistik;
    public $statusperusahaan;
    public $institusi;
    public $kepemilikan;
    public $jaringanusaha;
    public $namatabel;
    //persiapan sidang only
    public $tsql;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['subject', 'in', 'range' => ['ju', 'su', 'se']],
            ['subject', 'string', 'max' => 2, 'min' => 2],
            [['vvertikal', 'vhorizontal', 'attributes', 'years', 'kdprop', 'kdkab', 'kdkec', 'kddesa', 'kdkategori', 'kdkbli', 'unitstatistik', 'statusperusahaan', 'institusi', 'kepemilikan', 'jaringanusaha'], 'safe'],
        ];
    }

    public function generateCustom() {
//atribut
        if (is_string($this->attributes)) {
            $attr = array_filter(explode(",", str_replace("null", "", $this->attributes)));
        } else {
            $attr = array_filter(str_replace("null", "", $this->attributes));
        }
//mengatur default subjek dan atribut jika atribut kosong
        if (count($attr) == 0) {
            if ($this->subject == "su" || $this->subject == "se") {
                array_push($attr, "survived1");
            } else {
                array_push($attr, "jumlahunit1");
                $this->subject = "ju";
            }
        }
//tahun
        if (is_string($this->years)) {
            $thn = array_filter(explode(",", str_replace("null", "", $this->years)));
        } else {
            $thn = array_filter(str_replace("null", "", $this->years));
        }
//mengatur default tahun jika tidak ada tahun yang dipilih
        if (count($thn) == 0) {

            array_push($thn, "2015");
        }
        $tabeltahun = array(); //untuk mengatur tahun dalam nama tabel
        $namatabel = "";
        if ($this->subject == "se") {
            if (count($attr) > 1) {
                $namatabel = "Survival Unit yang Masuk ";
            }
            $tabel = "survival_birth";

            foreach ($thn as $value) {
                $tabeltahun[$value] = ((int) $value - 3) . "-" . $value;
            }
        } elseif ($this->subject == "su") {
            if (count($attr) > 1) {
                $namatabel = "Survival Unit Usaha ";
            }
            $tabel = "survival_unit";
            foreach ($thn as $value) {
                $tabeltahun[$value] = ((int) $value - 3) . "-" . $value;
            }
        } else {
            if (count($attr) > 1) {
                $namatabel = "Jumlah Unit Usaha ";
            }
            $tabel = "jumlah_unit";
            foreach ($thn as $value) {
                $tabeltahun[$value] = $value;
            }
        }
//variabel vertikal dan horisontal
        $vvertikal1 = array_filter(explode(",", str_replace("null", "", $this->vvertikal)));
        $vhorizontal1 = array_filter(explode(",", str_replace("null", "", $this->vhorizontal)));
//meng-update nama tabel
        $namatabel = $namatabel . " menurut " . implode(", ", $vvertikal1) . ", " . implode(", ", $vhorizontal1);
        $lokasi = "";
//mengatur lokasi
        $prop1 = str_replace("null", "", $this->kdprop);
        $kab1 = str_replace("null", "", $this->kdkab);
        $kec1 = str_replace("null", "", $this->kdkec);
        $desa1 = str_replace("null", "", $this->kddesa);
        if (is_string($prop1)) {
            $kdprop1 = array_filter(explode(",", $prop1));
        } else {
            $kdprop1 = array_filter($prop1);
        }
        if (is_string($kab1)) {
            $kdkab1 = array_filter(explode(",", $kab1));
        } else {
            $kdkab1 = array_filter($kab1);
        }
        if (is_string($kec1)) {
            $kdkec1 = array_filter(explode(",", $kec1));
        } else {
            $kdkec1 = array_filter($kec1);
        }
        if (is_string($desa1)) {
            $kddesa1 = array_filter(explode(",", $desa1));
        } else {
            $kddesa1 = array_filter($desa1);
        }

        if (count($kdprop1) == 0) {
            $lokasi = "Indonesia";
        } elseif (count($kdkab1) == 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $lokasi = "Provinsi ";
            foreach ($propinsi as $value) {
                $lokasi = $lokasi . trim($value->nmprop);
            }
        } elseif (count($kdkec1) == 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $kabupaten = Kabupaten::find()->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $lokasi = "Kabupaten/Kota ";
            foreach ($kabupaten as $value) {
                $lokasi = $lokasi . trim($value->nmkab);
            }
            $lokasi = $lokasi . " Provinsi ";
            foreach ($propinsi as $value) {
                $lokasi = $lokasi . trim($value->nmprop);
            }
        } elseif (count($kddesa1) == 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $kabupaten = Kabupaten::find()->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $kecamatan = Kecamatan::find()->where(['kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $lokasi = "Kecamatan ";

            foreach ($kecamatan as $value) {
                $lokasi = $lokasi . trim($value->nmkec);
            }
            $lokasi = $lokasi . " Kabupaten/Kota ";
            foreach ($kabupaten as $value) {
                $lokasi = $lokasi . trim($value->nmkab);
            }
            $lokasi = $lokasi . " Provinsi ";
            foreach ($propinsi as $value) {
                $lokasi = $lokasi . trim($value->nmprop);
            }
        } elseif (count($kddesa1) > 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $kabupaten = Kabupaten::find()->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $kecamatan = Kecamatan::find()->where(['kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $desa = Desa::find()->where(['kddesa' => $kddesa1[0], 'kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();

            if (count($kddesa1) == 1) {
                $lokasi = "Desa ";
                foreach ($desa as $value) {
                    $lokasi = $lokasi . trim($value->nmdesa);
                }
            }
            $lokasi = $lokasi . " Kecamatan ";
            foreach ($kecamatan as $value) {
                $lokasi = $lokasi . trim($value->nmkec);
            }
            $lokasi = $lokasi . " Kabupaten/Kota ";
            foreach ($kabupaten as $value) {
                $lokasi = $lokasi . trim($value->nmkab);
            }
            $lokasi = $lokasi . " Provinsi ";
            foreach ($propinsi as $value) {
                $lokasi = $lokasi . trim($value->nmprop);
            }
        }
        if (is_string($this->kdkategori)) {
            $kdkategori1 = array_filter(explode(",", str_replace("null", "", $this->kdkategori)));
        } else {
            $kdkategori1 = array_filter(str_replace("null", "", $this->kdkategori));
        }

        if (is_string($this->kdkbli)) {
            $kdkbli1 = array_filter(explode(",", str_replace("null", "", $this->kdkbli)));
        } else {
            $kdkbli1 = array_filter(str_replace("null", "", $this->kdkbli));
        }

        if (is_string($this->unitstatistik)) {
            $kdsu1 = array_filter(explode(",", str_replace("null", "", $this->unitstatistik)));
        } else {
            $kdsu1 = array_filter(str_replace("null", "", $this->unitstatistik));
        }

        if (is_string($this->statusperusahaan)) {
            $kdkondisi1 = array_filter(explode(",", str_replace("null", "", $this->statusperusahaan)));
        } else {
            $kdkondisi1 = array_filter(str_replace("null", "", $this->statusperusahaan));
        }

        if (is_string($this->institusi)) {
            $kdinstitusi1 = array_filter(explode(",", str_replace("null", "", $this->institusi)));
        } else {
            $kdinstitusi1 = array_filter(str_replace("null", "", $this->institusi));
        }

        if (is_string($this->kepemilikan)) {
            $kdkepemilikan1 = array_filter(explode(",", str_replace("null", "", $this->kepemilikan)));
        } else {
            $kdkepemilikan1 = array_filter(str_replace("null", "", $this->kepemilikan));
        }

        if (is_string($this->jaringanusaha)) {
            $kdjaringanusaha1 = array_filter(explode(",", str_replace("null", "", $this->jaringanusaha)));
        } else {
            $kdjaringanusaha1 = array_filter(str_replace("null", "", $this->jaringanusaha));
        }

        $vertikal = array();
        $join = "";
        $group = array();

        foreach ($vvertikal1 as $value) {
            switch ($value) {
                case "Desa":
                    array_push($vertikal, "desa.[nmdesa] AS [Desa]");
                    $join.=" JOIN [desa] desa ON p.[kddesa] = desa.[kddesa]";
                    if (count($attr) > 1) {
                        array_push($group, "desa.[nmdesa]");
                    }
                    break;
                case "Kecamatan":
                    array_push($vertikal, "kec.[nmkec] AS [Kecamatan]");
                    $join.=" JOIN [kecamatan] kec ON kec.[kdkec] = p.[kdkec] ";
                    if (count($attr) > 1) {
                        array_push($group, "kec.[nmkec]");
                    }
                    break;
                case "Kabupaten":
                    array_push($vertikal, "kab.[nmkab] AS [Kabupaten]");
                    $join.=" JOIN [kabupaten] kab ON kab.[kdkab] = p.[kdkab] ";
                    if (count($attr) > 1) {
                        array_push($group, "kab.[nmkab]");
                    }
                    break;
                case "Provinsi":
                    array_push($vertikal, "prop.[nmprop] AS [Provinsi]");
                    $join.=" JOIN [propinsi] prop ON prop.[kdprop] = p.[kdprop] ";
                    if (count($attr) > 1) {
                        array_push($group, "prop.[nmprop]");
                    }
                    break;
                case "Kategori":
                    array_push($vertikal, "kat.[nmkategori] AS [Kategori]");
                    $join.=" JOIN [kategori] kat ON kat.[kdkategori] = p.[kdkategori] ";
                    if (count($attr) > 1) {
                        array_push($group, "kat.[nmkategori] ");
                    }
                    break;
                case "Kbli":
                    array_push($vertikal, "kbli.[nmkbli] AS [KBLI]");
                    $join.=" JOIN [kbli] kbli ON kbli.[kdkbli] = p.[kdkbli] ";
                    if (count($attr) > 1) {
                        array_push($group, "kbli.[nmkbli]");
                    }
                    break;
                case "Status Perusahaan":
                    array_push($vertikal, "kon.[nmkondisi] AS [Status Perusahaan]");
                    $join.=" JOIN [statusperusahaan] kon ON kon.[kdkondisi] = p.[statusperusahaan] ";
                    if (count($attr) > 1) {
                        array_push($group, "kon.[nmkondisi]");
                    }
                    break;
                case "Unit Statistik":
                    array_push($vertikal, "su.[nmsu] AS [Unit Statistik]");
                    $join.=" JOIN [unitstatistik] su ON su.[kdsu] = p.[unitstatistik] ";
                    if (count($attr) > 1) {
                        array_push($group, "su.[nmsu]");
                    }
                    break;
                case "Sektor Institusi":
                    array_push($vertikal, "ins.[nminstitusi] AS [Sektor Institusi]");
                    $join.=" JOIN [institusi] ins ON ins.[kdinstitusi] = p.[institusi] ";
                    if (count($attr) > 1) {
                        array_push($group, "ins.[nminstitusi]");
                    }
                    break;
                case "Kepemilikan":
                    array_push($vertikal, "kep.[nmkepemilikan] AS [Kepemilikan]");
                    $join.=" JOIN [kepemilikan] kep ON kep.[kdkepemilikan] = p.[kepemilikan] ";
                    if (count($attr) > 1) {
                        array_push($group, "kep.[nmkepemilikan]");
                    }
                    break;
                case "Jaringan Usaha":
                    array_push($vertikal, "ju.[nmjaringanusaha] AS [Jaringan Usaha]");
                    $join.=" JOIN [jaringanusaha] ju ON ju.[kdjaringanusaha] = p.[jaringanusaha] ";
                    if (count($attr) > 1) {
                        array_push($group, "ju.[nmjaringanusaha]");
                    }
                    break;
                case "Tahun":
                    array_push($vertikal, "p.[tahun] AS [Tahun]");
                    if (count($attr) > 1) {
                        array_push($group, "p.[tahun]");
                    }
                    break;
            }
        }
        $horisontal = array();
        $pivotfor = "";
        foreach ($vhorizontal1 as $value) {
            switch ($value) {
                case "Desa":
                    array_push($horisontal, "desa.[nmdesa] AS [Desa]");
                    $join.=" JOIN [desa] desa ON p.[kddesa] = desa.[kddesa]";
                    $row = (new \yii\db\Query())
                            ->select(['nmdesa'])
                            ->from('desa')
                            ->where(['in', 'kddesa', $kddesa1])
                            ->all();
                    $x=array();
                    foreach($row as $rows){
                    foreach($rows as $key=>$value){
                     array_push($x,$value);
                    }}
                    $pivotfor = " [Desa] IN ([" . implode("],[", $x) . "]) ";
                    if (count($attr) > 1) {
                        array_push($group, "desa.[nmdesa]");
                    }
                    break;
                case "Kecamatan":
                    array_push($horisontal, "kec.[nmkec] AS [Kecamatan]");
                    $join.=" JOIN [kecamatan] kec ON kec.[kdkec] = p.[kdkec] ";
                    $row = (new \yii\db\Query())
                            ->select(['nmkec'])
                            ->from('kecamatan')
                            ->where(['in', 'kdkec', $kdkec1])
                            ->all();
                    $x=array();
                    foreach($row as $rows){
                    foreach($rows as $key=>$value){
                     array_push($x,$value);
                    }}
                    $pivotfor = " [Kecamatan] IN ([" . implode("],[", $x) . "]) ";
                    if (count($attr) > 1) {
                        array_push($group, "kec.[nmkec]");
                    }
                    break;
                case "Kabupaten":
                    array_push($horisontal, "kab.[nmkab] AS [Kabupaten]");
                    $join.=" JOIN [kabupaten] kab ON kab.[kdkab] = p.[kdkab] ";
                    $row = (new \yii\db\Query())
                            ->select(['nmkab'])
                            ->from('kabupaten')
                            ->where(['in', 'kdkab', $kdkab1])
                            ->all();
                    $x=array();
                    foreach($row as $rows){
                    foreach($rows as $key=>$value){
                     array_push($x,$value);
                    }}
                    $pivotfor = " [Kabupaten] IN ([" . implode("],[", $x) . "]) ";
                    if (count($attr) > 1) {
                        array_push($group, "kab.[nmkab]");
                    }
                    break;
                case "Provinsi":
                    array_push($horisontal, "prop.[nmprop] AS [Provinsi]");
                    $join.=" JOIN [propinsi] prop ON prop.[kdprop] = p.[kdprop] ";
                    $row = (new \yii\db\Query())
                            ->select(['nmprop'])
                            ->from('propinsi')
                            ->where(['in', 'kdprop', $kdprop1])
                            ->all();
                    $x=array();
                    foreach($row as $rows){
                    foreach($rows as $key=>$value){
                     array_push($x,$value);
                    }}
                    $pivotfor = " [Provinsi] IN ([" . implode("],[", $x) . "]) ";
                                        if (count($attr) > 1) {
                        array_push($group, "prop.[nmprop]");
                    }
                    break;

                case "Kategori":
                    array_push($horisontal, "kat.[nmkategori] AS [Kategori]");
                    $join.=" JOIN [kategori] kat ON kat.[kdkategori] = p.[kdkategori] ";
                    $row = (new \yii\db\Query())
                            ->select(['nmkategori'])
                            ->from('kategori')
                            ->where(['in', 'kdkategori', $kdkategori1])
                            ->all();
                    $x=array();
                    foreach($row as $rows){
                    foreach($rows as $key=>$value){
                     array_push($x,$value);
                    }}
                    $pivotfor = " [Kategori] IN ([" . implode("],[", $x) . "]) ";
                    if (count($attr) > 1) {
                        array_push($group, "kat.[nmkategori] ");
                    }
                    break;
                case "Kbli":
                    array_push($horisontal, "kbli.[nmkbli] AS [KBLI]");
                    $join.=" JOIN [kbli] kbli ON kbli.[kdkbli] = p.[kdkbli] ";
                    $row = (new \yii\db\Query())
                            ->select(['nmkbli'])
                            ->from('kbli')
                            ->where(['in', 'kdkbli', $kdkbli1])
                            ->all();
                    $x=array();
                    foreach($row as $rows){
                    foreach($rows as $key=>$value){
                     array_push($x,$value);
                    }}
                    $pivotfor = " [KBLI] IN ([" . implode("],[", $x) . "]) ";
                    if (count($attr) > 1) {
                        array_push($group, "kbli.[nmkbli]");
                    }
                    break;
                case "Status Perusahaan":
                    //array_push($horisontal, "kon.[kdkondisi] AS [Status Perusahaan]");
                    array_push($horisontal, "kon.[nmkondisi] AS [Status Perusahaan]");
                    $join.=" JOIN [statusperusahaan] kon ON kon.[kdkondisi] = p.[statusperusahaan] ";
                    $pivotfor = " [Status Perusahaan] IN ([" . implode("],[", $kdkondisi1) . "]) ";
                    if (count($attr) > 1) {
                        array_push($group, "kon.[nmkondisi]");
                    }
                    break;
                case "Unit Statistik":
                    array_push($horisontal, "su.[nmsu] AS [Unit Statistik]");
                    $join.=" JOIN [unitstatistik] su ON su.[kdsu] = p.[unitstatistik] ";
                    $row = (new \yii\db\Query())
                            ->select(['nmsu'])
                            ->from('unitstatistik')
                            ->where(['in', 'kdsu', $kdsu1])
                            ->all();
                    $x=array();
                    foreach($row as $rows){
                    foreach($rows as $key=>$value){
                     array_push($x,$value);
                    }}
                    $pivotfor = " [Unit Statistik] IN ([" . implode("],[", $x) . "]) ";
                                        if (count($attr) > 1) {
                        array_push($group, "su.[nmsu]");
                    }
                    break;
                case "Sektor Institusi":
                    array_push($horisontal, "ins.[nminstitusi] AS [Sektor Institusi]");
                    $join.=" JOIN [institusi] ins ON ins.[kdinstitusi] = p.[institusi] ";
                    $row = (new \yii\db\Query())
                            ->select(['nminstitusi'])
                            ->from('institusi')
                            ->where(['in', 'kdinstitusi', $kdinstitusi1])
                            ->all();
                    $x=array();
                    foreach($row as $rows){
                    foreach($rows as $key=>$value){
                     array_push($x,$value);
                    }}
                    $pivotfor = " [Sektor Institusi] IN ([" . implode("],[", $x) . "]) ";
                    if (count($attr) > 1) {
                        array_push($group, "ins.[nminstitusi]");
                    }
                    break;
                case "Kepemilikan":
                    array_push($horisontal, "kep.[nmkepemilikan] AS [Kepemilikan]");
                    $join.=" JOIN [kepemilikan] kep ON kep.[kdkepemilikan] = p.[kepemilikan] ";
                    $row = (new \yii\db\Query())
                            ->select(['nmkepemilikan'])
                            ->from('kepemilikan')
                            ->where(['in', 'kdkepemilikan', $kdkepemilikan1])
                            ->all();
                    $x=array();
                    foreach($row as $rows){
                    foreach($rows as $key=>$value){
                     array_push($x,$value);
                    }}
                    $pivotfor = " [Kepemilikan] IN ([" . implode("],[", $x) . "]) ";
                    if (count($attr) > 1) {
                        array_push($group, "kep.[nmkepemilikan]");
                    }
                    break;
                case "Jaringan Usaha":
                    array_push($horisontal, "ju.[nmjaringanusaha] AS [Jaringan Usaha]");
                    $join.=" JOIN [jaringanusaha] ju ON ju.[kdjaringanusaha] = p.[jaringanusaha] ";
                    $row = (new \yii\db\Query())
                            ->select(['nmjaringanusaha'])
                            ->from('jaringanusaha')
                            ->where(['in', 'kdjaringanusaha', $kdjaringanusaha1])
                            ->all();
                    $x=array();
                    foreach($row as $rows){
                    foreach($rows as $key=>$value){
                     array_push($x,$value);
                    }}
                    $pivotfor = " [Jaringan Usaha] IN ([" . implode("],[", $x) . "]) ";
                    if (count($attr) > 1) {
                        array_push($group, "ju.[nmjaringanusaha]");
                    }
                    break;
                case "Tahun":
                    array_push($horisontal, "p.[tahun] AS [Tahun]");
                    $pivotfor = " [Tahun] IN ([" . implode("],[", $thn) . "]) ";
                    if (count($attr) > 1) {
                        array_push($group, "p.[tahun]");
                    } break;
                    
            }
        }

        $attrnama = array();
        $pivotsum = "";

        foreach ($attr as $value) {
            switch ($value) {
                case "jumlahunit":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM (p.[jumlahunit]) AS [Jumlah Akhir Tahun]");
                    } else {
                        array_push($attrnama, "p.[jumlahunit] AS [Jumlah Akhir Tahun]");
                        $pivotsum = " SUM ([Jumlah Akhir Tahun]) ";
                        $namatabel = "Jumlah Unit pada Akhir Tahun";
                    }
                    break;
                case "survived1":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[survived1]) AS [Survived Tahun I]");
                    } else {
                        array_push($attrnama, "p.[survived1] AS [Survived Tahun I]");
                        $pivotsum = " SUM ([Survived Tahun I]) ";
                        $namatabel = "Jumlah Unit yang Survived Tahun I";
                    }
                    break;
                case "survivalrate1":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[survivalrate1]) AS [Survival Rate Tahun I]");
                    } else {
                        array_push($attrnama, "p.[survivalrate1] AS [Survival Rate Tahun I]");
                        $pivotsum = " SUM ([Survival Rate Tahun I]) ";
                        $namatabel = "Survival Rate Tahun I";
                    }
                    break;
                case "survived2":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[survived2]) AS [Survived Tahun II]");
                    } else {
                        array_push($attrnama, "p.[survived2] AS [Survived Tahun II]");
                        $pivotsum = " SUM ([Survived Tahun II]) ";
                        $namatabel = "Jumlah Unit yang Survived Tahun II";
                    }
                    break;
                case "survivalrate2":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[survivalrate2]) AS [Survival Rate Tahun II]");
                    } else {
                        array_push($attrnama, "p.[survivalrate2] AS [Survival Rate Tahun II]");
                        $pivotsum = " SUM ([Survival Rate Tahun II]) ";
                        $namatabel = "Survival Rate Tahun II";
                    }
                    break;
                case "survived3":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[survived3]) AS [Survived Tahun III]");
                    } else {
                        array_push($attrnama, "p.[survived3] AS [Survived Tahun III]");
                        $pivotsum = " SUM ([Survived Tahun III]) ";
                        $namatabel = "Jumlah Unit yang Survived Tahun III";
                    }
                    break;
                case "survivalrate3":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[survivalrate3]) AS [Survival Rate Tahun III]");
                    } else {
                        array_push($attrnama, "p.[survivalrate3] AS [Survival Rate Tahun III]");
                        $pivotsum = " SUM ([Survival Rate Tahun III]) ";
                        $namatabel = "Survival Rate Tahun III";
                    }
                    break;
                case "jumlahmasuk":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[jumlahmasuk]) AS [Jumlah Masuk]");
                    } else {
                        array_push($attrnama, "p.[jumlahmasuk] AS [Jumlah Masuk]");
                        $pivotsum = " SUM ([Jumlah Masuk]) ";
                        $namatabel = "Jumlah Unit yang Masuk";
                    }
                    break;
                case "jumlahkeluar":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[jumlahkeluar]) AS [Jumlah Keluar]");
                    } else {
                        array_push($attrnama, "p.[jumlahkeluar] AS [Jumlah Keluar]");
                        $pivotsum = " SUM ([Jumlah Keluar]) ";
                        $namatabel = "Jumlah Unit yang Keluar";
                    }
                    break;
                case "jumlahunit0":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[jumlahunit0]) AS [Jumlah Awal Tahun]");
                    } else {
                        array_push($attrnama, "p.[jumlahunit0] AS [Jumlah Awal Tahun]");
                        $pivotsum = " SUM ([Jumlah Awal Tahun]) ";
                        $namatabel = "Jumlah Unit di Awal Tahun";
                    }
                    break;
                case "beroperasi":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[beroperasi]) AS [Jumlah Aktif Beroperasi]");
                    } else {
                        array_push($attrnama, "p.[beroperasi] AS [Jumlah Aktif Beroperasi]");
                        $pivotsum = " SUM ([Jumlah Aktif Beroperasi]) ";
                        $namatabel = "Jumlah Unit yang Aktif Beroperasi";
                    }
                    break;
                case "jumlahunit1":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[jumlahunit1]) AS [Jumlah Akhir Tahun]");
                    } else {
                        array_push($attrnama, "p.[jumlahunit1] AS [Jumlah Akhir Tahun]");
                        $pivotsum = " SUM ([Jumlah Akhir Tahun]) ";
                        $namatabel = "Jumlah Unit pada Akhir Tahun";
                    }
                    break;
                case "perubahan":
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[perubahan]) AS [Perubahan]");
                    } else {
                        array_push($attrnama, "p.[perubahan] AS [Perubahan]");
                        $pivotsum = " SUM ([Perubahan]) ";
                        $namatabel = "Perubahan Jumlah Unit";
                    }
                    break;
                default:
                    if (count($attr) > 1) {
                        array_push($attrnama, " SUM(p.[jumlahunit1]) AS [Jumlah Akhir Tahun]");
                    } else {
                        array_push($attrnama, "p.[jumlahunit1] AS [Jumlah Akhir Tahun]");
                        $pivotsum = " SUM ([Jumlah Akhir Tahun]) ";
                        $namatabel = "Jumlah Unit pada Akhir Tahun";
                    }
            }
        }

        //mengatur nama tabel
        $namatabel = strtoupper($namatabel . ", Tahun " . implode(", ", $tabeltahun) . " di " . $lokasi);
        $this->namatabel = $namatabel;

        $field = "";
        if (count($vertikal) != 0) {
            $field = $field . implode(",", $vertikal);
        }

        if (count($horisontal) != 0) {
            if (count($vertikal) != 0) {
                $field = $field . ",";
            }
            $field = $field . implode(",", $horisontal);
        }
        $kondisi = "";
        if (count($kdsu1) != 0) {
            $kondisi = $kondisi . "') and p.[unitstatistik] in ('" . implode("','", $kdsu1);
        }
        if (count($kdprop1) != 0) {
            $kondisi = $kondisi . "') and p.[kdprop] in ('" . implode("','", $kdprop1);
        }
        if (count($kdkab1) != 0) {
            $kondisi = $kondisi . "') and p.[kdkab] in ('" . implode("','", $kdkab1);
        }
        if (count($kdkec1) != 0) {
            $kondisi = $kondisi . "') and p.[kdkec] in ('" . implode("','", $kdkec1);
        }
        if (count($kddesa1) != 0) {
            $kondisi = $kondisi . "') and p.[kddesa] in ('" . implode("','", $kddesa1);
        }
        if (count($kdkategori1) != 0) {
            $kondisi = $kondisi . "') and p.[kdkategori] in ('" . implode("','", $kdkategori1);
        }
        if (count($kdkbli1) != 0) {
            $kondisi = $kondisi . "') and p.[kdkbli] in ('" . implode("','", $kdkbli1);
        }
        if (count($kdkondisi1) != 0) {
            $kondisi = $kondisi . "') and p.[statusperusahaan] in ('" . implode("','", $kdkondisi1);
        }
        if (count($kdinstitusi1) != 0) {
            $kondisi = $kondisi . "') and p.[institusi] in ('" . implode("','", $kdinstitusi1);
        }
        if (count($kdkepemilikan1) != 0) {
            $kondisi = $kondisi . "') and p.[kepemilikan] in ('" . implode("','", $kdkepemilikan1);
        }
        if (count($kdjaringanusaha1) != 0) {
            $kondisi = $kondisi . "') and p.[jaringanusaha] in ('" . implode("','", $kdjaringanusaha1);
        }
        if (count($attr) > 1) {
            //tabel biasa, variabel horisontal harus attributes
            $tsql = "SELECT " . $field;
            if ($field <> "") {
                $tsql.= ",";
            }

            $tsql.= implode(",", $attrnama)
                    . " FROM [" . $tabel . "] p "
                    . $join
                    . " WHERE p.[tahun] in ('" . implode("','", $thn)
                    . $kondisi . "')";
            if ($group <> null) {
                $tsql.= " GROUP BY " . implode(",", $group);
                $tsql.= " ORDER BY " . implode(",", $group);
            }
        } else {
            //T-SQL pivotting table
            $tsql = "SELECT *" . " FROM (" . "SELECT " . $field.",";
                     if ($field == ""||$pivotfor=="") {
                $tsql.="p.[tahun] AS [Tahun],";
            }
                    $tsql.= implode(",", $attrnama) . " FROM [" . $tabel . "] p "
                    . $join . " WHERE p.[tahun] in ('" . implode("','", $thn)
                    . $kondisi . "')" . ") AS [tabelsumber] "
                    . "PIVOT (" . $pivotsum . "FOR ";
                    if($pivotfor<>""){$tsql.=$pivotfor;}else{
                       $tsql .= " [Tahun] IN ([" . implode("],[", $thn) . "]) ";
                    }
                    $tsql.= ") AS [tabelbaru]";
        }
       
        $this->tsql = $tsql;

        $dataProvider = new SqlDataProvider([
            "sql" => $tsql,
        ]);

        return $dataProvider;
        //cek query
        // return $tsql;
    }

    public function saveGiven() {
//atribut
        if (is_string($this->attributes)) {
            $attr = array_filter(explode(",", str_replace("null", "", $this->attributes)));
        } else {
            $attr = array_filter(str_replace("null", "", $this->attributes));
        }
//mengatur default subjek dan atribut jika atribut kosong
        if (count($attr) == 0) {
            if ($this->subject == "su" || $this->subject == "se") {
                array_push($attr, "survived1");
            } else {
                array_push($attr, "jumlahunit1");
                $this->subject = "ju";
            }
        }
//tahun
        if (is_string($this->years)) {
            $thn = array_filter(explode(",", str_replace("null", "", $this->years)));
        } else {
            $thn = array_filter(str_replace("null", "", $this->years));
        }
//mengatur default tahun jika tidak ada tahun yang dipilih
        if (count($thn) == 0) {

            array_push($thn, "2015");
        }
        $tabeltahun = array(); //untuk mengatur tahun dalam nama tabel
        $namatabel = "";
        if ($this->subject == "se") {
            if (count($attr) > 1) {
                $namatabel = "Survival Unit yang Masuk ";
            }
            $tabel = "survival_birth";

            foreach ($thn as $value) {
                $tabeltahun[$value] = ((int) $value - 3) . "-" . $value;
            }
        } elseif ($this->subject == "su") {
            if (count($attr) > 1) {
                $namatabel = "Survival Unit Usaha ";
            }
            $tabel = "survival_unit";
            foreach ($thn as $value) {
                $tabeltahun[$value] = ((int) $value - 3) . "-" . $value;
            }
        } else {
            if (count($attr) > 1) {
                $namatabel = "Jumlah Unit Usaha ";
            }
            $tabel = "jumlah_unit";
            foreach ($thn as $value) {
                $tabeltahun[$value] = $value;
            }
        }
//variabel vertikal dan horisontal
        $vvertikal1 = array_filter(explode(",", str_replace("null", "", $this->vvertikal)));
        $vhorizontal1 = array_filter(explode(",", str_replace("null", "", $this->vhorizontal)));
//meng-update nama tabel
        $namatabel = $namatabel . " menurut " . implode(", ", $vvertikal1) . ", " . implode(", ", $vhorizontal1);
        $lokasi = "";
//mengatur lokasi
        $prop1 = str_replace("null", "", $this->kdprop);
        $kab1 = str_replace("null", "", $this->kdkab);
        $kec1 = str_replace("null", "", $this->kdkec);
        $desa1 = str_replace("null", "", $this->kddesa);
        if (is_string($prop1)) {
            $kdprop1 = array_filter(explode(",", $prop1));
        } else {
            $kdprop1 = array_filter($prop1);
        }
        if (is_string($kab1)) {
            $kdkab1 = array_filter(explode(",", $kab1));
        } else {
            $kdkab1 = array_filter($kab1);
        }
        if (is_string($kec1)) {
            $kdkec1 = array_filter(explode(",", $kec1));
        } else {
            $kdkec1 = array_filter($kec1);
        }
        if (is_string($desa1)) {
            $kddesa1 = array_filter(explode(",", $desa1));
        } else {
            $kddesa1 = array_filter($desa1);
        }

        if (count($kdprop1) == 0) {
            $lokasi = "Indonesia";
        } elseif (count($kdkab1) == 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $lokasi = "Provinsi ";
            foreach ($propinsi as $value) {
                $lokasi = $lokasi . trim($value->nmprop);
            }
        } elseif (count($kdkec1) == 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $kabupaten = Kabupaten::find()->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $lokasi = "Kabupaten/Kota ";
            foreach ($kabupaten as $value) {
                $lokasi = $lokasi . trim($value->nmkab);
            }
            $lokasi = $lokasi . " Provinsi ";
            foreach ($propinsi as $value) {
                $lokasi = $lokasi . trim($value->nmprop);
            }
        } elseif (count($kddesa1) == 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $kabupaten = Kabupaten::find()->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $kecamatan = Kecamatan::find()->where(['kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $lokasi = "Kecamatan ";

            foreach ($kecamatan as $value) {
                $lokasi = $lokasi . trim($value->nmkec);
            }
            $lokasi = $lokasi . " Kabupaten/Kota ";
            foreach ($kabupaten as $value) {
                $lokasi = $lokasi . trim($value->nmkab);
            }
            $lokasi = $lokasi . " Provinsi ";
            foreach ($propinsi as $value) {
                $lokasi = $lokasi . trim($value->nmprop);
            }
        } elseif (count($kddesa1) > 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $kabupaten = Kabupaten::find()->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $kecamatan = Kecamatan::find()->where(['kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $desa = Desa::find()->where(['kddesa' => $kddesa1[0], 'kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();

            if (count($kddesa1) == 1) {
                $lokasi = "Desa ";
                foreach ($desa as $value) {
                    $lokasi = $lokasi . trim($value->nmdesa);
                }
            }
            $lokasi = $lokasi . " Kecamatan ";
            foreach ($kecamatan as $value) {
                $lokasi = $lokasi . trim($value->nmkec);
            }
            $lokasi = $lokasi . " Kabupaten/Kota ";
            foreach ($kabupaten as $value) {
                $lokasi = $lokasi . trim($value->nmkab);
            }
            $lokasi = $lokasi . " Provinsi ";
            foreach ($propinsi as $value) {
                $lokasi = $lokasi . trim($value->nmprop);
            }
        }
        if (is_string($this->kdkategori)) {
            $kdkategori1 = array_filter(explode(",", str_replace("null", "", $this->kdkategori)));
        } else {
            $kdkategori1 = array_filter(str_replace("null", "", $this->kdkategori));
        }

        if (is_string($this->kdkbli)) {
            $kdkbli1 = array_filter(explode(",", str_replace("null", "", $this->kdkbli)));
        } else {
            $kdkbli1 = array_filter(str_replace("null", "", $this->kdkbli));
        }

        if (is_string($this->unitstatistik)) {
            $kdsu1 = array_filter(explode(",", str_replace("null", "", $this->unitstatistik)));
        } else {
            $kdsu1 = array_filter(str_replace("null", "", $this->unitstatistik));
        }

        if (is_string($this->statusperusahaan)) {
            $kdkondisi1 = array_filter(explode(",", str_replace("null", "", $this->statusperusahaan)));
        } else {
            $kdkondisi1 = array_filter(str_replace("null", "", $this->statusperusahaan));
        }

        if (is_string($this->institusi)) {
            $kdinstitusi1 = array_filter(explode(",", str_replace("null", "", $this->institusi)));
        } else {
            $kdinstitusi1 = array_filter(str_replace("null", "", $this->institusi));
        }

        if (is_string($this->kepemilikan)) {
            $kdkepemilikan1 = array_filter(explode(",", str_replace("null", "", $this->kepemilikan)));
        } else {
            $kdkepemilikan1 = array_filter(str_replace("null", "", $this->kepemilikan));
        }

        if (is_string($this->jaringanusaha)) {
            $kdjaringanusaha1 = array_filter(explode(",", str_replace("null", "", $this->jaringanusaha)));
        } else {
            $kdjaringanusaha1 = array_filter(str_replace("null", "", $this->jaringanusaha));
        }

        $namatabel = strtoupper($namatabel . ", Tahun " . implode(", ", $tabeltahun) . " di " . $lokasi);
        //menyimpan tabel
        $historytabel = new HistoryTabel();
        $historytabel->jenis = $this->subject;
        $historytabel->variabelvertikal = implode(",", $vvertikal1);
        $historytabel->variabelhorizontal = implode(",", $vhorizontal1);
        $historytabel->nmtabel = $namatabel;
        $historytabel->save();
        $tabel = HistoryTabel::find()->orderBy(['idtabel' => SORT_DESC])->one();
        $idtabel = $tabel->idtabel;
//menyimpan lokasi
        if (count($kdprop1) == 0) {
            if (in_array("Provinsi", $vvertikal1) || in_array("Provinsi", $vhorizontal1)) {
                $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])->all();
                foreach ($propinsi as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $value->kdprop;
                    $historyLokasi->save();
                }
            }
        } elseif (count($kdkab1) == 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            if (in_array("Kabupaten", $vvertikal1) || in_array("Kabupaten", $vhorizontal1)) {
                $kabupaten = Kabupaten::find()->where(['kdprop' => $kdprop1[0]])->all();
                foreach ($kabupaten as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $kdprop1[0];
                    $historyLokasi->kdkab = $value->kdkab;
                    $historyLokasi->save();
                }
            } else {
                foreach ($propinsi as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $value->kdprop;
                    $historyLokasi->save();
                }
            }
        } elseif (count($kdkec1) == 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $kabupaten = Kabupaten::find()->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            if (in_array("Kecamatan", $vvertikal1) || in_array("Kecamatan", $vhorizontal1)) {
                $kecamatan = Kecamatan::find()->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
                foreach ($kecamatan as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $kdprop1[0];
                    $historyLokasi->kdkab = $kdkab1[0];
                    $historyLokasi->kdkec = $value->kdkec;
                    $historyLokasi->save();
                }
            } else {
                foreach ($kabupaten as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $kdprop1[0];
                    $historyLokasi->kdkab = $value->kdkab;
                    $historyLokasi->save();
                }
            }
        } elseif (count($kddesa1) == 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $kabupaten = Kabupaten::find()->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $kecamatan = Kecamatan::find()->where(['kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();

            if (in_array("Desa", $vvertikal1) || in_array("Desa", $vhorizontal1)) {
                $desa = Desa::find()->where(['kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
                foreach ($desa as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $kdprop1[0];
                    $historyLokasi->kdkab = $kdkab1[0];
                    $historyLokasi->kdkec = $kdkec1[0];
                    $historyLokasi->kddesa = $value->kddesa;
                    $historyLokasi->save();
                }
            } else {
                foreach ($kecamatan as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $kdprop1[0];
                    $historyLokasi->kdkab = $kdkab1[0];
                    $historyLokasi->kdkec = $value->kdkec;
                    $historyLokasi->save();
                }
            }
        } elseif (count($kddesa1) > 0) {
            $propinsi = Propinsi::find()->where(['not', ['kdprop' => '95']])->andWhere(['not', ['kdprop' => '00']])
                            ->andWhere(['kdprop' => $kdprop1[0]])->all();
            $kabupaten = Kabupaten::find()->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $kecamatan = Kecamatan::find()->where(['kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();
            $desa = Desa::find()->where(['kddesa' => $kddesa1[0], 'kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->all();

            foreach ($desa as $value) {
                $historyLokasi = new HistoryLokasi();
                $historyLokasi->idtabel = $idtabel;
                $historyLokasi->kdprop = $kdprop1[0];
                $historyLokasi->kdkab = $kdkab1[0];
                $historyLokasi->kdkec = $kdkec1[0];
                $historyLokasi->kddesa = $value->kddesa;
                $historyLokasi->save();
            }
        }
//menyimpan atribut
        foreach ($attr as $value) {
            $historyAttribute = new HistoryAttributes();
            $historyAttribute->idtabel = $idtabel;
            switch ($value) {
                case 'jumlahmasuk':
                    $historyAttribute->jumlahmasuk = 1;
                    break;
                case 'survivalrate3':
                    $historyAttribute->survivalrate3 = 1;
                    break;
                case 'jumlahkeluar':
                    $historyAttribute->jumlahkeluar = 1;
                    break;
                case 'jumlahunit0':
                    $historyAttribute->jumlahunit0 = 1;
                    break;
                case 'beroperasi':
                    $historyAttribute->beroperasi = 1;
                    break;
                case 'jumlahunit1':
                    $historyAttribute->jumlahunit1 = 1;
                    break;
                case 'perubahan':
                    $historyAttribute->perubahan = 1;
                    break;
                case 'survived1':
                    $historyAttribute->survived1 = 1;
                    break;
                case 'survived2':
                    $historyAttribute->survived2 = 1;
                    break;
                case 'survived3':
                    $historyAttribute->survived3 = 1;
                    break;
                case 'survivalrate1':
                    $historyAttribute->survivalrate1 = 1;
                    break;
                case 'survivalrate2':
                    $historyAttribute->survivalrate2 = 1;
                    break;
                case 'jumlahunit':
                    $historyAttribute->jumlahunit = 1;
                    break;
            }
            $historyAttribute->save();
        }
//menyimpan tahun
        foreach ($thn as $value) {
            $historyTahun = new HistoryTahun();
            $historyTahun->idtabel = $idtabel;
            $historyTahun->tahun = $value;
            $historyTahun->save();
        }
//menyimpan kategori
        foreach ($kdkategori1 as $value) {
            $historyKategori = new HistoryKdkategori();
            $historyKategori->idtabel = $idtabel;
            $historyKategori->kdkategori = $value;
            $historyKategori->save();
        }
//menyimpan kbli
        foreach ($kdkbli1 as $value) {
            $historyKbli = new HistoryKdkbli();
            $historyKbli->idtabel = $idtabel;
            $historyKbli->kdkbli = $value;
            $historyKbli->save();
        }
//menyimpan unit statistik
        foreach ($kdsu1 as $value) {
            $historyUnitstatistik = new HistoryUnitstatistik();
            $historyUnitstatistik->idtabel = $idtabel;
            $historyUnitstatistik->unitstatistik = $value;
            $historyUnitstatistik->save();
        }
//menyimpan status perusahaan
        foreach ($kdkondisi1 as $value) {
            $historyStatusperusahaan = new HistoryStatusperusahaan();
            $historyStatusperusahaan->idtabel = $idtabel;
            $historyStatusperusahaan->statusperusahaan = $value;
            $historyUnitstatistik->save();
        }
//menyimpan sektor institusi

        foreach ($kdinstitusi1 as $value) {
            $historyInstitusi = new HistoryInstitusi();
            $historyInstitusi->idtabel = $idtabel;
            $historyInstitusi->institusi = $value;
            $historyInstitusi->save();
        }
//menyimpan kode kepemilikan
        foreach ($kdkepemilikan1 as $value) {
            $historyKepemilikan = new HistoryKepemilikan();
            $historyKepemilikan->idtabel = $idtabel;
            $historyKepemilikan->kepemilikan = $value;
            $historyKepemilikan->save();
        }
//menyimpan jaringan usaha
        foreach ($kdjaringanusaha1 as $value) {
            $historyJaringanusaha = new HistoryJaringanusaha();
            $historyJaringanusaha->idtabel = $idtabel;
            $historyJaringanusaha->jaringanusaha = $value;
            $historyJaringanusaha->save();
        }
    }

    public function getNamatabel() {
        return $this->namatabel;
    }

    public function getTsql() {
        return $this->tsql;
    }

}
