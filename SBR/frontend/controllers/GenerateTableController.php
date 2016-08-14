<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use \frontend\models\GeneratorTable;
use frontend\models\Propinsi;
use frontend\models\Kabupaten;
use frontend\models\Kecamatan;
use frontend\models\Desa;
use frontend\models\Tahun;

class GenerateTableController extends Controller {

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        $model = new GenerateCustomTableForm();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM user',
        ]);

        return $this->render('tesTable', [
                    'dataProvider' => $dataProvider,
                    'model' => $model
        ]);
    }

    public function actionGetDesa($kdprop, $kdkab, $kdkec) {
        if (Yii::$app->request->getIsPost()) {
            $desa = Desa::find()->where(['kdprop' => $kdprop])
                            ->andWhere(['kdkab' => $kdkab])
                            ->andWhere(['kdkec' => $kdkec])->all();
            $countDesa = Desa::find()->where(['kdprop' => $kdprop])
                            ->andWhere(['kdkab' => $kdkab])
                            ->andWhere(['kdkec' => $kdkec])->count();
            if ($countDesa > 0) {
                foreach ($desa as $desa) {
                    echo "<option value='" . $desa->kddesa . "'>" . $desa->nmdesa . "</option>";
                }
            } else {
                echo"<option></option>";
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function actionGetKecamatan($kdprop, $kdkab) {
        if (Yii::$app->request->getIsPost()) {
            $kecamatan = Kecamatan::find()
                            ->where(['kdprop' => $kdprop])
                            ->andWhere(['kdkab' => $kdkab])->all();
            $countKecamatan = Kecamatan::find()
                            ->where(['kdprop' => $kdprop])
                            ->andWhere(['kdkab' => $kdkab])->count();
            if ($countKecamatan > 0) {
                foreach ($kecamatan as $kecamatan) {
                    echo "<option value='" . $kecamatan->kdkec . "'>" . $kecamatan->nmkec . "</option>";
                }
            } else {
                echo"<option></option>";
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function actionGetKabupaten($kdprop,$nmpro) {
        if (Yii::$app->request->getIsPost()) {
          
          $kdprop1 = explode(",", $kdprop);
          $nmprop1 = explode(",", $nmprop);
            foreach ($kdprop1 as $id) {
                echo "<optgroup value='" . $id ."name='" .$nmprop1."'>";
                $kabupaten = Kabupaten::find()
                        ->where(['kdprop' => $id,])
                        ->andWhere(['not', ['kdkab' => '00']])
                        ->all();
                $countKabupaten = Kabupaten::find()
                        ->where(['kdprop' => $id,])
                        ->andWhere(['not', ['kdkab' => '00']])
                        ->count();
                if ($countKabupaten > 0) {
                    foreach ($kabupaten as $kabupaten) {
                        echo "<option value='" . $kabupaten->kdkab . "'>" . $kabupaten->nmkab . "</option>";
                    }
                    echo "</optgroup>";
                } else {
                    echo"<option></option>";
                }
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function actionGetYears($subject) {
        if (Yii::$app->request->getIsPost()) {
            $years = Tahun::find()
                    ->where(['jenis' => $subject,])
                    ->all();
            $countYears = Tahun::find()
                    ->where(['jenis' => $subject,])
                    ->count();
            if ($countYears > 0) {
                if ($subject == 'ju') {
                    foreach ($years as $year) {

                        echo "<option value='" . $year->tahun . "'>" . $year->tahun . "</option>";
                    }
                } else {
                    foreach ($years as $year) {

                        echo "<option value='" . $year->tahun . "'>" . ((int) $year->tahun - 3) . "-" . $year->tahun . "</option>";
                    }
                }
            } else {
                echo"<option></option>";
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function actionGetMandatoryvariables($attributes, $tahun) {
        if (Yii::$app->request->getIsPost()) {
            //Wajib dipilih
            $attr = explode(",", $attributes);
            $thn = explode(",", $tahun);
            if (sizeof($attr) > 1) {
                echo "<li>Attributes</li>";
            }
            if (sizeof($thn) > 1) {
                echo "<li>Tahun</li>";
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function actionGetVariablelist($kdprop) {
        $variableList = array(
            "kdkbli" => "KBLI",
            "unitstatistik" => "Unit Statistik",
            "statusperusahaan" => "Status Perusahaan",
            "kdkategori" => "Kategori",
            "institusi" => "Sektor Institusi",
            "kepemilikan" => "Kepemilikan",
            "jaringanusaha" => "Jaringan Usaha",
            "lokasi" => "Lokasi",
            "tahun" => "Tahun",
            "atribut" => "Atribut",
        );
        if (Yii::$app->request->getIsPost()) {
            foreach ($variableList as $key => $value) {
                echo "<li value='" . $key . "'>" . $value . "</li>";
            }
            if ($kdprop == "null" || $kdprop == "") {
                echo "<li>Propinsi</li>";
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function actionGetLocationvariables($kdprop, $kdkab, $kdkec, $kddesa) {
        if (Yii::$app->request->getIsPost()) {
            echo "<li>Prop:" . $kdprop . "</li>";
            echo "<li>Kab:" . $kdkab . "</li>";
            echo "<li>Kec:" . $kdkec . "</li>";
            echo "<li>Des:" . $kddesa . "</li>";
//           if ($kdprop <> null && $kdprop <> "") {//Jika propinsi ada yang dipilih,
//                if ($kdkab == null || $kdkab == "") {
//                    echo "<li>Kabupaten</li>";
//                } elseif ($kdkec == null || $kdkec == "") {
//                    echo "<li>Kecamatan</li>";
//                } elseif ($kddesa == null || $kddesa == "") {
//                    echo "<li>Desa</li>";
//                }
//            }
        } else {
            echo "Invalid request.";
        }
    }

    public function actionGetAttributes($subject) {
        if (Yii::$app->request->getIsPost()) {
            if ($subject == 'se') {
                $attributes = array(
                    "jumlahmasuk" => "Jumlah Masuk",
                    "survived1" => "Survived Tahun I",
                    "survivalrate1" => "Survival Rate Tahun I",
                    "survived2" => "Survived Tahun II",
                    "survivalrate2" => "Survival Rate Tahun II",
                    "survived3" => "Survived Tahun III",
                    "survivalrate3" => "Survival Rate Tahun III",);
                foreach ($attributes as $key => $value) {
                    echo "<option value='" . $key . "'>" . $value . "</option>";
                }
            } else if ($subject == 'su') {
                $attributes = array(
                    "jumlahunit" => "Jumlah Akhir Tahun",
                    "survived1" => "Survived Tahun I",
                    "survivalrate1" => "Survival Rate Tahun I",
                    "survived2" => "Survived Tahun II",
                    "survivalrate2" => "Survival Rate Tahun II",
                    "survived3" => "Survived Tahun III",
                    "survivalrate3" => "Survival Rate Tahun III",
                );
                foreach ($attributes as $key => $value) {
                    echo "<option value='" . $key . "'>" . $value . "</option>";
                }
            } else {
                $attributes = array(
                    "jumlahmasuk" => "Jumlah Masuk",
                    "jumlahkeluar" => "Jumlah Keluar",
                    "jumlahunit0" => "Jumlah Awal Tahun",
                    "beroperasi" => "Jumlah Aktif Beroperasi",
                    "jumlahunit1" => "Jumlah Akhir Tahun",
                    "perubahan" => "Perubahan",);
                foreach ($attributes as $key => $value) {
                    echo "<option value='" . $key . "'>" . $value . "</option>";
                }
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function actionGenerateCustomTable() {
        $model = new GeneratorTable();

        return $this->render('_formCustom', [
                    'model' => $model,
                        //  'form'=>$form,
        ]);
    }

    public function actionGetTableColumn($attributes, $tahun, $kdprop, $kdkab, $kdkec, $kddesa) {
        $variableList = array(
            "kdkbli" => "KBLI",
            "unitstatistik" => "Unit Statistik",
            "statusperusahaan" => "Status Perusahaan",
            "kdkategori" => "Kategori",
            "institusi" => "Sektor Institusi",
            "kepemilikan" => "Kepemilikan",
            "jaringanusaha" => "Jaringan Usaha",
//            "tahun" => "tahun",
//            "kddesa" => "Desa",
//            "kdkec" => "Kecamatan",
//            "kdkab" => "Kabupaten",
//            "kdprop" => "Propinsi",
////            Attributes:
//            "jumlahmasuk" => "Jumlah Masuk",
//            "jumlahkeluar" => "Jumlah Keluar",
//            "jumlahunit0" => "Jumlah Awal Tahun",
//            "beroperasi" => "Jumlah Aktif Beroperasi",
//            "jumlahunit1" => "Jumlah Akhir Tahun",
//            "perubahan" => "Perubahan",
//            "survived1" => "Survived Tahun I",
//            "survivalrate1" => "Survival Rate Tahun I",
//            "survived2" => "Survived Tahun II",
//            "survivalrate2" => "Survival Rate Tahun II",
//            "survived3" => "Survived Tahun III",
//            "survivalrate3" => "Survival Rate Tahun III",
        );

        if (Yii::$app->request->getIsPost()) {
            //Wajib dipilih
            if (sizeof($tahun) > 1) {
                echo "<li>Tahun</li>";
            }
            if (sizeof($attributes) > 1) {
                echo "<li>Attributes</li>";
            }
            if ($kdprop <> null && $kdprop <> "") {//Jika propinsi ada yang dipilih,
                if ($kdkab == null || $kdkab == "") {
                    echo "<li>Kabupaten</li>";
                } elseif ($kdkec == null || $kdkec == "") {
                    echo "<li>Kecamatan</li>";
                } elseif ($kddesa == null || $kddesa == "") {
                    echo "<li>Desa</li>";
                }
            }
            //Optional
            foreach ($attributes as $value) {
                echo "<li>" . $variableList[$value] . "</li>";
            }
            if ($kdprop == null || $kdprop == "") {
                echo "<li>Propinsi</li>";
            }
        } else {
            echo "Invalid request.";
        }
    }

}
