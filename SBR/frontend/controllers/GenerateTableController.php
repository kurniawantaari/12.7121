<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use frontend\models\GeneratorTableForm;
use frontend\models\Kabupaten;
use frontend\models\Kecamatan;
use frontend\models\Desa;
use frontend\models\Tahun;
use frontend\models\Kbli;

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
            $kdprop1 = array_filter(explode(",", str_replace("null", "", $kdprop)));
            $kdkab1 = array_filter(explode(",", str_replace("null", "", $kdkab)));
            $kdkec1 = array_filter(explode(",", str_replace("null", "", $kdkec)));
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
//$kdkab1= explode(",", $kdkab);
//  $kdprop1= explode(",", $kdprop);

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

    public function actionGetKabupaten($kdprop) {
        if (Yii::$app->request->getIsPost()) {
            $kabupaten = Kabupaten::find()
                    ->where(['kdprop' => $kdprop,])
                    ->andWhere(['not', ['kdkab' => '00']])
                    ->all();
            $countKabupaten = Kabupaten::find()
                    ->where(['kdprop' => $kdprop,])
                    ->andWhere(['not', ['kdkab' => '00']])
                    ->count();
            if ($countKabupaten > 0) {
                foreach ($kabupaten as $kabupaten) {
                    echo "<option value='" . $kabupaten->kdkab . "'>" . $kabupaten->nmkab . "</option>";
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

    public function actionGetVariables($kdkategori, $kdkbli, $kdsu, $kdkondisi, $kdinstitusi, $kdkepemilikan, $kdjaringanusaha, $kdprop, $kdkab, $kdkec, $kddesa, $attributes, $tahun) {
        if (Yii::$app->request->getIsPost()) {
            $kdkategori1 = array_filter(explode(",", str_replace("null", "", $kdkategori)));
            $kdkbli1 = array_filter(explode(",", str_replace("null", "", $kdkbli)));
            $kdsu1 = array_filter(explode(",", str_replace("null", "", $kdsu)));
            $kdkondisi1 = array_filter(explode(",", str_replace("null", "", $kdkondisi)));
            $kdinstitusi1 = array_filter(explode(",", str_replace("null", "", $kdinstitusi)));
            $kdkepemilikan1 = array_filter(explode(",", str_replace("null", "", $kdkepemilikan)));
            $kdjaringanusaha1 = array_filter(explode(",", str_replace("null", "", $kdjaringanusaha)));
            $attr = array_filter(explode(",", str_replace("null", "", $attributes)));
            $thn = array_filter(explode(",", str_replace("null", "", $tahun)));
            $kdprop1 = array_filter(explode(",", str_replace("null", "", $kdprop)));
            $kdkab1 = array_filter(explode(",", str_replace("null", "", $kdkab)));
            $kdkec1 = array_filter(explode(",", str_replace("null", "", $kdkec)));
            $kddesa1 = array_filter(explode(",", str_replace("null", "", $kddesa)));

            if (sizeof($attr) > 1) {
                echo "<li value='Attributes'>Attributes</li>";
            }
            if (sizeof($thn) > 1) {
                echo "<li value='Tahun'>Tahun</li>";
            }
            if (sizeof($kdprop1) == 0) {
                echo "<li value='Provinsi'>Provinsi</li>";
            } elseif (sizeof($kdkab1) == 0) {
                echo "<li value='Kabupaten'>Kabupaten</li>";
            } elseif (sizeof($kdkec1) == 0) {
                echo "<li value='Kecamatan'>Kecamatan</li>";
            } elseif (sizeof($kddesa1) == 0) {
                echo "<li value='Desa'>Desa</li>";
            }
            if (sizeof($kdkategori1) > 1) {
                echo "<li value='Kategori'>Kategori</li>";
            }
            if (sizeof($kdsu1) > 1) {
                echo "<li value='Unit Statistik'>Unit Statistik</li>";
            }
            if (sizeof($kdkbli1) > 1) {
                echo "<li value='Kbli'>Kbli</li>";
            }
            if (sizeof($kdkondisi1) > 1) {
                echo "<li value='Status Perusahaan'>Status Perusahaan</li>";
            }
            if (sizeof($kdinstitusi1) > 1) {
                echo "<li value='Sektor Institusi'>Sektor Institusi</li>";
            }
            if (sizeof($kdkepemilikan1) > 1) {
                echo "<li value='Kepemilikan'>Kepemilikan</li>";
            }
            if (sizeof($kdjaringanusaha1) > 1) {
                echo "<li value='Jaringan Usaha'>Jaringan Usaha</li>";
            }
        } else {
            echo "Invalid request.";
        }
    }

    public function actionGetKbli($kdkategori) {
        if (Yii::$app->request->getIsPost()) {
            $kdkat = array_filter(explode(",", str_replace("null", "", $kdkategori)));
            foreach ($kdkat as $value) {
                $kbli = Kbli::find()
                        ->where(['kdkategori' => $kdkat])
                        ->andWhere(['tahun' => '2015'])
                        ->all();
                $countKbli = Kbli::find()->where(['kdkategori' => $kdkat])
                        ->andWhere(['tahun' => '2015'])
                        ->all();
                if ($countKbli > 0) {
                    echo "<optgroup label='Kategori " . $value . "'>";
                    foreach ($kbli as $kbli) {

                        echo "<option value='" . $kbli->kdkbli . "'>" . $kbli->nmkbli . "</option>";
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
        $model = new GeneratorTableForm();
        if ($model->load(Yii::$app->request->post())) {
            $tabel = $model->generateCustom();
            print_r($tabel);
//echo $tabel;
            //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            //return $this->render('view',               ['tabel'=>$tabel]            );
            //return $tabel   ;         
        } else {
            return $this->render('_formCustom', ['model' => $model]);
        }
    }

    public function actionGenerateGivenTable() {
        //$model = new GeneratorTable();
        //$model = new \frontend\models\HistoryTabel();
        return $this->render('givenTable', [
                    'model' => $model,
                        //  'form'=>$form,
        ]);
    }

}
