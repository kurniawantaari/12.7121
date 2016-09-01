<?php

namespace frontend\models;

use yii;
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
use yii\db\Query;

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

    public function saveTable(array $vvertikal1, array $vhorizontal1, array $kdprop1, array $kdkab1, array $kdkec1, array $kddesa1, array $attr, string $namatabel, array $thn, array $kdkategori1, array $kdkondisi1, array $kdkbli1, array $kdsu1, array $kdinstitusi1, array $kdkepemilikan1, array $kdjaringanusaha1) {
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
        if ($this->subject == "se") {
            $namatabel = "Survival Unit yang Masuk ";
            $tabel = "survival_birth";
            foreach ($thn as $value) {
                $tabeltahun[$value] = ((int) $value - 3) . "-" . $value;
            }
        } elseif ($this->subject == "su") {
            $namatabel = "Survival Unit Usaha ";
            $tabel = "survival_unit";
            foreach ($thn as $value) {
                $tabeltahun[$value] = ((int) $value - 3) . "-" . $value;
            }
        } else {
            $namatabel = "Jumlah Unit Usaha ";
            $tabel = "jumlah_unit";
            foreach ($thn as $value) {
                $tabeltahun[$value] = $value;
            }
        }
//variabel vertikal dan horisontal
        $vvertikal1 = array_filter(explode(",", str_replace("null", "", $this->vvertikal)));
        $vhorizontal1 = array_filter(explode(",", str_replace("null", "", $this->vhorizontal)));
//meng-update nama tabel
        $namatabel = $namatabel . " menurut " . implode(",", $vvertikal1) . "," . implode(",", $vhorizontal1);
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

//mengatur nama tabel
        $namatabel = strtoupper($namatabel . ", Tahun " . implode(",", $tabeltahun) . " di " . $lokasi);
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
            $kdkepemilikan1 = array_filter(",", str_replace("null", "", $this->kepemilikan));
        }

        if (is_string($this->jaringanusaha)) {
            $kdjaringanusaha1 = array_filter(explode(",", str_replace("null", "", $this->jaringanusaha)));
        } else {
            $kdjaringanusaha1 = array_filter(str_replace("null", "", $this->jaringanusaha));
        }

        $vertikal = array();
        foreach ($vvertikal1 as $value) {
            switch ($value) {
                case "Desa":
                    array_push($vertikal, "kddesa");
                    break;
                case "Kecamatan":
                    array_push($vertikal, "kdkec");
                    break;
                case "Kabupaten":
                    array_push($vertikal, "kdkab");
                    break;
                case "Provinsi":
                    array_push($vertikal, "kdprop");
                    break;
                case "Kategori":
                    array_push($vertikal, "kdkategori");
                    break;
                case "Kbli":
                    array_push($vertikal, "kdkbli");
                    break;
                case "Status Perusahaan":
                    array_push($vertikal, "statusperusahaan");
                    break;
                case "Unit Statistik":
                    array_push($vertikal, "unitstatistik");
                    break;
                case "Sektor Institusi":
                    array_push($vertikal, "institusi");
                    break;
                case "Kepemilikan":
                    array_push($vertikal, "kepemilikan");
                    break;
                case "Jaringan Usaha":
                    array_push($vertikal, "jaringanusaha");
                    break;
                case "Tahun":
                    array_push($vertikal, "tahun");
                    break;
            }
        }
        $horisontal = array();
        foreach ($vhorizontal1 as $value) {
            switch ($value) {
                case "Desa":
                    array_push($horisontal, "kddesa");
                    break;
                case "Kecamatan":
                    array_push($horisontal, "kdkec");
                    break;
                case "Kabupaten":
                    array_push($horisontal, "kdkab");
                    break;
                case "Provinsi":
                    array_push($horisontal, "kdprop");
                    break;
                case "Kategori":
                    array_push($horisontal, "kdkategori");
                    break;
                case "Kbli":
                    array_push($horisontal, "kdkbli");
                    break;
                case "Status Perusahaan":
                    array_push($horisontal, "statusperusahaan");
                    break;
                case "Unit Statistik":
                    array_push($horisontal, "unitstatistik");

                    break;
                case "Sektor Institusi":
                    array_push($horisontal, "institusi");

                    break;
                case "Kepemilikan":
                    array_push($horisontal, "kepemilikan");
                    break;
                case "Jaringan Usaha":
                    array_push($horisontal, "jaringanusaha");
                    break;
                case "Tahun":
                    array_push($horisontal, "tahun");
                    break;
            }
        }
        $tabelatribut = array();
        foreach ($attr as $value) {
            switch ($value) {
                case "jumlahunit":
                    $tabelatribut[$value] = "Jumlah_Akhir_Tahun";
                    break;
                case "survived1":
                    $tabelatribut[$value] = "Survived_Tahun_I";
                    break;
                case "survivalrate1":
                    $tabelatribut[$value] = "Survival_Rate_Tahun_I";
                    break;
                case "survived2":
                    $tabelatribut[$value] = "Survived_Tahun_II";
                    break;
                case "survivalrate2":
                    $tabelatribut[$value] = "Survival_Rate_Tahun_II";
                    break;
                case "survived3":
                    $tabelatribut[$value] = "Survived_Tahun_III";
                    break;
                case "survivalrate3":
                    $tabelatribut[$value] = "Survival_Rate_Tahun _III";
                    break;
                case "jumlahmasuk":
                    $tabelatribut[$value] = "Jumlah_Masuk";
                    break;
                case "jumlahkeluar":
                    $tabelatribut[$value] = "Jumlah_Keluar";
                    break;
                case "jumlahunit0":
                    $tabelatribut[$value] = "Jumlah_Awal_Tahun";
                    break;
                case "beroperasi":
                    $tabelatribut[$value] = "Jumlah_Aktif_Beroperasi";
                    break;
                case "jumlahunit1":
                    $tabelatribut[$value] = "Jumlah_Akhir_Tahun";
                    break;
                case "perubahan":
                    $tabelatribut[$value] = "Perubahan";
                    break;
                default:$tabelatribut[$value] = "Jumlah_Akhir_Tahun";
            }
        }
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
        foreach ($tabelatribut as $key => $value) {
            $field1 = $field
                    . ", sum(" . $key
                    . ") as " . $value;
        }

        $kondisi = "";
        if (count($kdsu1) != 0) {
            $kondisi = $kondisi . "') and unitstatistik in ('" . implode("','", $kdsu1);
        }
        if (count($kdprop1) != 0) {
            $kondisi = $kondisi . "') and kdprop in ('" . implode("','", $kdprop1);
        }
        if (count($kdkab1) != 0) {
            $kondisi = $kondisi . "') and kdkab in ('" . implode("','", $kdkab1);
        }
        if (count($kdkec1) != 0) {
            $kondisi = $kondisi . "') and kdkec in ('" . implode("','", $kdkec1);
        }
        if (count($kddesa1) != 0) {
            $kondisi = $kondisi . "') and kddesa in ('" . implode("','", $kddesa1);
        }
        if (count($kdkategori1) != 0) {
            $kondisi = $kondisi . "') and kdkategori in ('" . implode("','", $kdkategori1);
        }
        if (count($kdkbli1) != 0) {
            $kondisi = $kondisi . "') and kdkbli in ('" . implode("','", $kdkbli1);
        }
        if (count($kdkondisi1) != 0) {
            $kondisi = $kondisi . "') and statusperusahaan in ('" . implode("','", $kdkondisi1);
        }
        if (count($kdinstitusi1) != 0) {
            $kondisi = $kondisi . "') and institusi in ('" . implode("','", $kdinstitusi1);
        }
        if (count($kdkepemilikan1) != 0) {
            $kondisi = $kondisi . "') and kepemilikan in ('" . implode("','", $kdkepemilikan1);
        }
        if (count($kdjaringanusaha1) != 0) {
            $kondisi = $kondisi . "') and jaringanusaha in ('" . implode("','", $kdjaringanusaha1);
        }
        $connection = Yii::$app->getDb();
        //T-SQL pivotting table
        $tsql="";
//        $tsql = "SELECT " . $field1
//                . " FROM " . $tabel
//                . " WHERE tahun in ('" . implode("','", $thn)
//                . $kondisi
//                . "')"
//                . " GROUP BY " . $field
//                . " ORDER BY " . $field . ";";
        $command = $connection->createCommand($tsql);
        
        
// returns all rows of the query result
        $result = $command->queryAll();
//cek array
        return $result;
//saveTable($vvertikal1,$vhorizontal1,$kdprop1,$kdkab1,$kdkec1,$kddesa1,$attr,$namatabel,$thn,$kdkategori1,$kdkondisi1,$kdkbli1,$kdsu1,$kdinstitusi1,$kdkepemilikan1,$kdjaringanusaha1);
        //return $resulttable;
    }

}
