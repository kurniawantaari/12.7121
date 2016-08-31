<?php

namespace frontend\models;

use Yii;
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
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\data\SqlDataProvider;

/**
 * ContactForm is the model behind the contact form.
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

    public function saveTable() {
        $attr = array_filter(explode(",", str_replace("null", "", $this->attributes)));
        //  $attr = array_filter(str_replace("null", "", $this->attributes));

        if (sizeof($attr) == 0) {
            if ($this->subject == "su" || $this->subject == "se") {
                $attr[] = "survived1";
            } else {
                $attr[] = "jumlahunit";
                $this->subject = "ju";
            }
        }
        $namatabel = "";
        if ($this->subject == "se") {
            $namatabel = $namatabel . "Survival Unit yang Masuk ";
        } elseif ($this->subject == "su") {
            $namatabel = $namatabel . "Survival Unit Usaha ";
        } else {
            $namatabel = $namatabel . "Jumlah Unit Usaha ";
        }
        //kalau sudah ada update tabel aja, bkan bikin baru
        $vvertikal1 = array_filter(explode(",", str_replace("null", "", $this->vvertikal)));
        $vhorizontal1 = array_filter(explode(",", str_replace("null", "", $this->vhorizontal)));

        $namatabel = $namatabel . " menurut " . implode(",", $vvertikal1) . "," . implode(",", $vhorizontal1);
        $historytabel = new HistoryTabel();
        $historytabel->jenis = $this->subject;
        $historytabel->variabelvertikal = implode(",", $vvertikal1);
        $historytabel->variabelhorizontal = implode(",", $vhorizontal1);
        $historytabel->jumlah_hits = 1;
        $historytabel->save();
        $tabel = HistoryTabel::find()->orderBy(['idtabel' => SORT_DESC])->one();
        $idtabel = $tabel->idtabel;

        $lokasi = "";
//        $kdprop1 = array_filter(explode(",", str_replace("null", "", $this->kdprop)));
//        $kdkab1 = array_filter(explode(",", str_replace("null", "", $this->kdkab)));
//        $kdkec1 = array_filter(explode(",", str_replace("null", "", $this->kdkec)));
//        $kddesa1 = array_filter(explode(",", str_replace("null", "", $this->kddesa)));
//        $kdprop1 = array_filter(str_replace("null", "", $this->kdprop));
//        $kdkab1 = array_filter(str_replace("null", "", $this->kdkab));
//        $kdkec1 = array_filter(str_replace("null", "", $this->kdkec));
//        $kddesa1 = array_filter(str_replace("null", "", $this->kddesa));
        $kdprop1 = str_replace("null", "", $this->kdprop);
        $kdkab1 = str_replace("null", "", $this->kdkab);
        $kdkec1 = str_replace("null", "", $this->kdkec);
        $kddesa1 = str_replace("null", "", $this->kddesa);
//        if (sizeof($kdprop1) == 0) {
//            if (in_array("Provinsi", $vvertikal1) || in_array("Provinsi", $vhorizontal1)) {
//                foreach ($kdprop1 as $value) {
//                    $historyLokasi = new HistoryLokasi();
//                    $historyLokasi->idtabel = $idtabel;
//                    $historyLokasi->kdprop = $value;
//                    $historyLokasi->save();
//                }
//            }
//            $lokasi = "Indonesia";
//        } elseif (sizeof($kdkab1) == 0) {
//            $lokasi = "Provinsi " . Propinsi::find('nmprop')->where(['kdprop' => $kdprop1[0]])->one();
//            foreach ($kdprop1 as $value) {
//                $historyLokasi = new HistoryLokasi();
//                $historyLokasi->idtabel = $idtabel;
//                $historyLokasi->kdprop = $value;
//                $historyLokasi->save();
//            }
//        } elseif (sizeof($kdkec1) == 0) {
//            $lokasi = "Kabupaten/Kota " . Kabupaten::findOne('nmkab')->where(['kdkab' => $kdkab1, 'kdprop' => kdprop1[0]]) . " Provinsi " . Propinsi::findOne('nmprop')->where(['kdprop' => $kdprop1[0]]);
//            foreach ($kdkab1 as $value) {
//                $historyLokasi = new HistoryLokasi();
//                $historyLokasi->idtabel = $idtabel;
//                $historyLokasi->kdprop = $kdprop1[0];
//                $historyLokasi->kdkab = $value;
//                $historyLokasi->save();
//            }
//        } elseif (sizeof($kddesa1) == 0) {
//            $lokasi = "Kecamatan " . Kecamatan::findOne('nmkec')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1[0]]) . " Kabupaten/Kota " . Kabupaten::findOne('nmkab')->where(['kdkab' => $kdkab1, 'kdprop' => $kdprop1[0]]) . " Provinsi " . Propinsi::findOne('nmprop')->where(['kdprop' => $kdprop1[0]]);
//            foreach ($kdkec1 as $value) {
//                $historyLokasi = new HistoryLokasi();
//                $historyLokasi->idtabel = $idtabel;
//                $historyLokasi->kdprop = $kdprop1[0];
//                $historyLokasi->kdkab = $kdkab1[0];
//                $historyLokasi->kdkec = $value;
//                $historyLokasi->save();
//            }
//        } elseif (sizeof($kddesa1) > 0) {
//            foreach ($kddesa1 as $value) {
//                $historyLokasi = new HistoryLokasi();
//                $historyLokasi->idtabel = $idtabel;
//                $historyLokasi->kdprop = $kdprop1[0];
//                $historyLokasi->kdkab = $kdkab1[0];
//                $historyLokasi->kdkec = $kdkec1[0];
//                $historyLokasi->kddesa = $value;
//                $historyLokasi->save();
//            }
//            if (sizeof($kddesa1) == 1) {
//                $lokasi = "Desa " . Desa::find('nmdesa')->where(['kddesa' => $kddesa1, 'kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->one() . " Kecamatan " . Kecamatan::find('nmkec')->where(['kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->one() . " Kabupaten " . Kabupaten::find('nmkab')->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->one() . " Provinsi " . Propinsi::find('nmprop')->where(['kdprop' => $kdprop1[0]])->one();
//            } elseif (sizeof($kddesa1) > 1) {
//                $lokasi = "Kecamatan " . Kecamatan::find('nmkec')->where(['kdkec' => $kdkec1[0], 'kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->one() . " Kabupaten/Kota " . Kabupaten::find('nmkab')->where(['kdkab' => $kdkab1[0], 'kdprop' => $kdprop1[0]])->one() . " Provinsi " . Propinsi::find('nmprop')->where(['kdprop' => $kdprop1[0]]);
//            }
//        }
        if ($kdprop1 == "" || $kdprop1 == null) {
            if (in_array("Provinsi", $vvertikal1) || in_array("Provinsi", $vhorizontal1)) {
                //$prop = Propinsi::find('kdprop')->all();
                $prop = (new \yii\db\Query())->select(['kdprop'])->from('propinsi')->all();
                return $prop;
                foreach ($prop as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $value;
                    $historyLokasi->save();
                }
            }
            $lokasi = "Indonesia";
        } elseif ($kdkab1 == "" || $kdkab1 == null) {
            $lokasi = "Provinsi " . Propinsi::find('nmprop')->where(['kdprop' => $kdprop1])->one();
            $prop = Propinsi::find('kdprop')->where(['kdprop' => $kdprop1])->all();
            foreach ($prop as $value) {
                $historyLokasi = new HistoryLokasi();
                $historyLokasi->idtabel = $idtabel;
                $historyLokasi->kdprop = $value;
                $historyLokasi->save();
            }
        } elseif ($kdkec1 == "" || $kdkec1 == null) {
            $lokasi = "Kabupaten/Kota " . Kabupaten::findOne('nmkab')->where(['kdkab' => $kdkab1, 'kdprop' => kdprop1]) . " Provinsi " . Propinsi::findOne('nmprop')->where(['kdprop' => $kdprop1]);
            $kab = Kabupaten::find('kdkab')->where(['kdkab' => $kdkab1, 'kdprop' => kdprop1])->all();
            foreach ($kab as $value) {
                $historyLokasi = new HistoryLokasi();
                $historyLokasi->idtabel = $idtabel;
                $historyLokasi->kdprop = $kdprop1;
                $historyLokasi->kdkab = $value;
                $historyLokasi->save();
            }
        } elseif ($kddesa1 == "" || $kddesa1 == null) {
            $lokasi = "Kecamatan " . Kecamatan::findOne('nmkec')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1]) . " Kabupaten/Kota " . Kabupaten::findOne('nmkab')->where(['kdkab' => $kdkab1, 'kdprop' => $kdprop1]) . " Provinsi " . Propinsi::findOne('nmprop')->where(['kdprop' => $kdprop1]);
            $kec = Kecamatan::find('kdkec')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->all();
            foreach ($kec as $value) {
                $historyLokasi = new HistoryLokasi();
                $historyLokasi->idtabel = $idtabel;
                $historyLokasi->kdprop = $kdprop1;
                $historyLokasi->kdkab = $kdkab1;
                $historyLokasi->kdkec = $value;
                $historyLokasi->save();
            }
        } else {
            if (sizeof($kddesa1) == 1) {
                $lokasi = "Desa " . Desa::find('nmdesa')->where(['kddesa' => $kddesa1, 'kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->one() . " Kecamatan " . Kecamatan::find('nmkec')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->one() . " Kabupaten " . Kabupaten::find('nmkab')->where(['kdkab' => $kdkab1, 'kdprop' => $kdprop1])->one() . " Provinsi " . Propinsi::find('nmprop')->where(['kdprop' => $kdprop1])->one();
                $desa = Desa::find('kddesa')->where(['kddesa' => $kddesa1, 'kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->all();
                foreach ($desa as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $kdprop1;
                    $historyLokasi->kdkab = $kdkab1;
                    $historyLokasi->kdkec = $kdkec1;
                    $historyLokasi->kddesa = $value;
                    $historyLokasi->save();
                }
            } elseif (sizeof($kddesa1) > 1) {
                $lokasi = "Kecamatan " . Kecamatan::find('nmkec')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->one() . " Kabupaten/Kota " . Kabupaten::find('nmkab')->where(['kdkab' => $kdkab1, 'kdprop' => $kdprop1])->one() . " Provinsi " . Propinsi::find('nmprop')->where(['kdprop' => $kdprop1]);
                $desa = Desa::find('kddesa')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->all();
                foreach ($desa as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $kdprop1;
                    $historyLokasi->kdkab = $kdkab1;
                    $historyLokasi->kdkec = $kdkec1;
                    $historyLokasi->kddesa = $value;
                    $historyLokasi->save();
                }
            }
        }
        $namatabel = $namatabel . " di " . $lokasi;
        $tabel->nmtabel = $namatabel;
        $tabel->save();

        foreach ($attr as $value) {
            $historyAttributes = new HistoryAttributes();
            $historyAttributes->idtabel = $idtabel;
            if ($value == 'jumlahmasuk') {
                $historyAttributes->jumlahmasuk = 1;
            } elseif ($value == 'survivalrate3') {
                $historyAttributes->survivalrate3 = 1;
            } elseif ($value == 'jumlahkeluar') {
                $historyAttributes->jumlahkeluar = 1;
            } elseif ($value == 'jumlahunit0') {
                $historyAttributes->jumlahunit0 = 1;
            } elseif ($value == 'beroperasi') {
                $historyAttributes->beroperasi = 1;
            } elseif ($value == 'jumlahunit1') {
                $historyAttributes->jumlahunit1 = 1;
            } elseif ($value == 'perubahan') {
                $historyAttributes->perubahan = 1;
            } elseif ($value == 'survived1') {
                $historyAttributes->survived1 = 1;
            } elseif ($value == 'survived2') {
                $historyAttributes->survived2 = 1;
            } elseif ($value == 'survived3') {
                $historyAttributes->survived3 = 1;
            } elseif ($value == 'survivalrate1') {
                $historyAttributes->survivalrate1 = 1;
            } elseif ('survivalrate2' == $value) {
                $historyAttributes->survivalrate2 = 1;
            }
            $historyAttributes->save();
        }
//              $thn = array_filter(str_replace("null", "", $this->years));
        $thn = array_filter(explode(",", str_replace("null", "", $this->years)));
        foreach ($thn as $value) {
            $historyTahuns = new HistoryTahun();
            $historyTahuns->idtabel = $idtabel;
            $historyTahuns->tahun = $value;
            $historyTahuns->save();
        }
        //    $kdkategori1 = array_filter(str_replace("null", "", $this->kdkategori));
        $kdkategori1 = array_filter(explode(",", str_replace("null", "", $this->kdkategori)));
        foreach ($kdkategori1 as $value) {
            $historyKategori = new HistoryKdkategori();
            $historyKategori->idtabel = $idtabel;
            $historyKategori->kdkategori = $value;
            $historyKategori->save();
        }
        $kdkbli1 = array_filter(explode(",", str_replace("null", "", $this->kdkbli)));
        //     $kdkbli1 = array_filter(str_replace("null", "", $this->kdkbli));
        foreach ($kdkbli1 as $value) {
            $historyKbli = new HistoryKdkbli();
            $historyKbli->idtabel = $idtabel;
            $historyKbli->kdkbli = $value;
            $historyKbli->save();
        }
        //    $kdsu1 = array_filter(str_replace("null", "", $this->unitstatistik));
        $kdsu1 = array_filter(explode(",", str_replace("null", "", $this->unitstatistik)));
        foreach ($kdsu1 as $value) {
            $historyUnitstatistiks = new HistoryUnitstatistik();
            $historyUnitstatistiks->idtabel = $idtabel;
            $historyUnitstatistiks->unitstatistik = $value;
            $historyUnitstatistiks->save();
        }
        //$kdkondisi1 = array_filter(str_replace("null", "", $this->statusperusahaan));
        $kdkondisi1 = array_filter(explode(",", str_replace("null", "", $this->statusperusahaan)));
        foreach ($kdkondisi1 as $value) {
            $historyStatusperusahaans = new HistoryStatusperusahaan();
            $historyStatusperusahaans->idtabel = $idtabel;
            $historyStatusperusahaans->statusperusahaan = $value;
            $historyUnitstatistiks->save();
        }
        $kdinstitusi1 = array_filter(explode(",", str_replace("null", "", $this->institusi)));
        // $kdinstitusi1 = array_filter(str_replace("null", "", $this->institusi));
        foreach ($kdinstitusi1 as $value) {
            $historyInstitusi = new HistoryInstitusi();
            $historyInstitusi->idtabel = $idtabel;
            $historyInstitusi->institusi = $value;
            $historyInstitusi->save();
        }
        $kdkepemilikan1 = array_filter(explode(",", str_replace("null", "", $this->kepemilikan)));
        //    $kdkepemilikan1 = array_filter(",", str_replace("null", "", $this->kepemilikan));
        foreach ($kdkepemilikan1 as $value) {
            $historyKepemilikans = new HistoryKepemilikan();
            $historyKepemilikans->idtabel = $idtabel;
            $historyKepemilikans->kepemilikan = $value;
            $historyKepemilikans->save();
        }
        $kdjaringanusaha1 = array_filter(explode(",", str_replace("null", "", $this->jaringanusaha)));
        //   $kdjaringanusaha1 = array_filter(str_replace("null", "", $this->jaringanusaha));
        foreach ($kdjaringanusaha1 as $value) {
            $historyJaringanusaha = new HistoryJaringanusaha();
            $historyJaringanusaha->idtabel = $idtabel;
            $historyJaringanusaha->jaringanusaha = $value;
            $historyJaringanusaha->save();
        }
    }

    public function save2() {
        $attr = array_filter(explode(",", str_replace("null", "", $this->attributes)));
        if (sizeof($attr) == 0) {
            if ($this->subject == "su" || $this->subject == "se") {
                $attr[] = "survived1";
            } else {
                $attr[] = "jumlahunit";
                $this->subject = "ju";
            }
        }
        $namatabel = "";
        if ($this->subject == "se") {
            $namatabel = $namatabel . "Survival Unit yang Masuk ";
        } elseif ($this->subject == "su") {
            $namatabel = $namatabel . "Survival Unit Usaha ";
        } else {
            $namatabel = $namatabel . "Jumlah Unit Usaha ";
        }
        $vvertikal1 = array_filter(explode(",", str_replace("null", "", $this->vvertikal)));
        $vhorizontal1 = array_filter(explode(",", str_replace("null", "", $this->vhorizontal)));

        $namatabel = $namatabel . " menurut " . implode(",", $vvertikal1) . "," . implode(",", $vhorizontal1);
        $historytabel = new HistoryTabel();
        $historytabel->jenis = $this->subject;
        $historytabel->variabelvertikal = implode(",", $vvertikal1);
        $historytabel->variabelhorizontal = implode(",", $vhorizontal1);
        $historytabel->jumlah_hits = 1;
        $historytabel->save();
        $tabel = HistoryTabel::find()->orderBy(['idtabel' => SORT_DESC])->one();
        $idtabel = $tabel->idtabel;

        $lokasi = "";
        $kdprop1 = str_replace("null", "", $this->kdprop);
        $kdkab1 = str_replace("null", "", $this->kdkab);
        $kdkec1 = str_replace("null", "", $this->kdkec);
        $kddesa1 = str_replace("null", "", $this->kddesa);
        if ($kdprop1 == "" || $kdprop1 == null) {
            if (in_array("Provinsi", $vvertikal1) || in_array("Provinsi", $vhorizontal1)) {
                //$prop = Propinsi::find('kdprop')->all();
                $prop = (new \yii\db\Query())->select(['kdprop'])->from('propinsi')->all();
                return $prop;
                foreach ($prop as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $value;
                    $historyLokasi->save();
                }
            }
            $lokasi = "Indonesia";
        } elseif ($kdkab1 == "" || $kdkab1 == null) {
            $lokasi = "Provinsi " . Propinsi::find('nmprop')->where(['kdprop' => $kdprop1])->one();
            $prop = Propinsi::find('kdprop')->where(['kdprop' => $kdprop1])->all();
            foreach ($prop as $value) {
                $historyLokasi = new HistoryLokasi();
                $historyLokasi->idtabel = $idtabel;
                $historyLokasi->kdprop = $value;
                $historyLokasi->save();
            }
        } elseif ($kdkec1 == "" || $kdkec1 == null) {
            $lokasi = "Kabupaten/Kota " . Kabupaten::findOne('nmkab')->where(['kdkab' => $kdkab1, 'kdprop' => kdprop1]) . " Provinsi " . Propinsi::findOne('nmprop')->where(['kdprop' => $kdprop1]);
            $kab = Kabupaten::find('kdkab')->where(['kdkab' => $kdkab1, 'kdprop' => kdprop1])->all();
            foreach ($kab as $value) {
                $historyLokasi = new HistoryLokasi();
                $historyLokasi->idtabel = $idtabel;
                $historyLokasi->kdprop = $kdprop1;
                $historyLokasi->kdkab = $value;
                $historyLokasi->save();
            }
        } elseif ($kddesa1 == "" || $kddesa1 == null) {
            $lokasi = "Kecamatan " . Kecamatan::findOne('nmkec')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1]) . " Kabupaten/Kota " . Kabupaten::findOne('nmkab')->where(['kdkab' => $kdkab1, 'kdprop' => $kdprop1]) . " Provinsi " . Propinsi::findOne('nmprop')->where(['kdprop' => $kdprop1]);
            $kec = Kecamatan::find('kdkec')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->all();
            foreach ($kec as $value) {
                $historyLokasi = new HistoryLokasi();
                $historyLokasi->idtabel = $idtabel;
                $historyLokasi->kdprop = $kdprop1;
                $historyLokasi->kdkab = $kdkab1;
                $historyLokasi->kdkec = $value;
                $historyLokasi->save();
            }
        } else {
            if (sizeof($kddesa1) == 1) {
                $lokasi = "Desa " . Desa::find('nmdesa')->where(['kddesa' => $kddesa1, 'kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->one() . " Kecamatan " . Kecamatan::find('nmkec')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->one() . " Kabupaten " . Kabupaten::find('nmkab')->where(['kdkab' => $kdkab1, 'kdprop' => $kdprop1])->one() . " Provinsi " . Propinsi::find('nmprop')->where(['kdprop' => $kdprop1])->one();
                $desa = Desa::find('kddesa')->where(['kddesa' => $kddesa1, 'kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->all();
                foreach ($desa as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $kdprop1;
                    $historyLokasi->kdkab = $kdkab1;
                    $historyLokasi->kdkec = $kdkec1;
                    $historyLokasi->kddesa = $value;
                    $historyLokasi->save();
                }
            } elseif (sizeof($kddesa1) > 1) {
                $lokasi = "Kecamatan " . Kecamatan::find('nmkec')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->one() . " Kabupaten/Kota " . Kabupaten::find('nmkab')->where(['kdkab' => $kdkab1, 'kdprop' => $kdprop1])->one() . " Provinsi " . Propinsi::find('nmprop')->where(['kdprop' => $kdprop1]);
                $desa = Desa::find('kddesa')->where(['kdkec' => $kdkec1, 'kdkab' => $kdkab1, 'kdprop' => $kdprop1])->all();
                foreach ($desa as $value) {
                    $historyLokasi = new HistoryLokasi();
                    $historyLokasi->idtabel = $idtabel;
                    $historyLokasi->kdprop = $kdprop1;
                    $historyLokasi->kdkab = $kdkab1;
                    $historyLokasi->kdkec = $kdkec1;
                    $historyLokasi->kddesa = $value;
                    $historyLokasi->save();
                }
            }
        }
        $namatabel = $namatabel . " di " . $lokasi;
        $tabel->nmtabel = $namatabel;
        $tabel->save();

        foreach ($attr as $value) {
            $historyAttributes = new HistoryAttributes();
            $historyAttributes->idtabel = $idtabel;
            if ($value == 'jumlahmasuk') {
                $historyAttributes->jumlahmasuk = 1;
            } elseif ($value == 'survivalrate3') {
                $historyAttributes->survivalrate3 = 1;
            } elseif ($value == 'jumlahkeluar') {
                $historyAttributes->jumlahkeluar = 1;
            } elseif ($value == 'jumlahunit0') {
                $historyAttributes->jumlahunit0 = 1;
            } elseif ($value == 'beroperasi') {
                $historyAttributes->beroperasi = 1;
            } elseif ($value == 'jumlahunit1') {
                $historyAttributes->jumlahunit1 = 1;
            } elseif ($value == 'perubahan') {
                $historyAttributes->perubahan = 1;
            } elseif ($value == 'survived1') {
                $historyAttributes->survived1 = 1;
            } elseif ($value == 'survived2') {
                $historyAttributes->survived2 = 1;
            } elseif ($value == 'survived3') {
                $historyAttributes->survived3 = 1;
            } elseif ($value == 'survivalrate1') {
                $historyAttributes->survivalrate1 = 1;
            } elseif ('survivalrate2' == $value) {
                $historyAttributes->survivalrate2 = 1;
            }
            $historyAttributes->save();
        }
        $thn = array_filter(explode(",", str_replace("null", "", $this->years)));
        foreach ($thn as $value) {
            $historyTahuns = new HistoryTahun();
            $historyTahuns->idtabel = $idtabel;
            $historyTahuns->tahun = $value;
            $historyTahuns->save();
        }
        $kdkategori1 = array_filter(explode(",", str_replace("null", "", $this->kdkategori)));
        foreach ($kdkategori1 as $value) {
            $historyKategori = new HistoryKdkategori();
            $historyKategori->idtabel = $idtabel;
            $historyKategori->kdkategori = $value;
            $historyKategori->save();
        }
        $kdkbli1 = array_filter(explode(",", str_replace("null", "", $this->kdkbli)));
        foreach ($kdkbli1 as $value) {
            $historyKbli = new HistoryKdkbli();
            $historyKbli->idtabel = $idtabel;
            $historyKbli->kdkbli = $value;
            $historyKbli->save();
        }
        $kdsu1 = array_filter(explode(",", str_replace("null", "", $this->unitstatistik)));
        foreach ($kdsu1 as $value) {
            $historyUnitstatistiks = new HistoryUnitstatistik();
            $historyUnitstatistiks->idtabel = $idtabel;
            $historyUnitstatistiks->unitstatistik = $value;
            $historyUnitstatistiks->save();
        }
        $kdkondisi1 = array_filter(explode(",", str_replace("null", "", $this->statusperusahaan)));
        foreach ($kdkondisi1 as $value) {
            $historyStatusperusahaans = new HistoryStatusperusahaan();
            $historyStatusperusahaans->idtabel = $idtabel;
            $historyStatusperusahaans->statusperusahaan = $value;
            $historyUnitstatistiks->save();
        }
        $kdinstitusi1 = array_filter(explode(",", str_replace("null", "", $this->institusi)));
        foreach ($kdinstitusi1 as $value) {
            $historyInstitusi = new HistoryInstitusi();
            $historyInstitusi->idtabel = $idtabel;
            $historyInstitusi->institusi = $value;
            $historyInstitusi->save();
        }
        $kdkepemilikan1 = array_filter(explode(",", str_replace("null", "", $this->kepemilikan)));
        foreach ($kdkepemilikan1 as $value) {
            $historyKepemilikans = new HistoryKepemilikan();
            $historyKepemilikans->idtabel = $idtabel;
            $historyKepemilikans->kepemilikan = $value;
            $historyKepemilikans->save();
        }
        $kdjaringanusaha1 = array_filter(explode(",", str_replace("null", "", $this->jaringanusaha)));
        foreach ($kdjaringanusaha1 as $value) {
            $historyJaringanusaha = new HistoryJaringanusaha();
            $historyJaringanusaha->idtabel = $idtabel;
            $historyJaringanusaha->jaringanusaha = $value;
            $historyJaringanusaha->save();
        }
    }

    public function generate() {
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT kdkategori, tahun, jumlahmasuk ' .
            'FROM jumlah_unit ' .
            'WHERE tahun=2010']);
//penamaan tabel= [subject] +menurut [[variabel]] + tahun [[tahun]] +[[tempat]]
//<h4 class="wizard-title">Table</h4>
//nama tabel di uppercase
// Renders a export dropdown menu
//echo ExportMenu::widget([
//    //  'dataProvider' => $dataProvider,
//    'columns' => $gridColumns
//]);
//        return GridView::widget([
//                    'dataProvider' => $dataProvider,
//                    'columns' => $gridColumns,
//                    'hover' => true,
//        ]);
        return $dataProvider;
    }

    public function column() {
        return $gridColumns = [
            'kdkategori',
            'jumlahmasuk',
            'tahun',
        ];
    }

    function console_log($data) {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }

}
