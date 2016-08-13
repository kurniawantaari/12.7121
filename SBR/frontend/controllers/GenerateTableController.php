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
            } else {
                echo"<option></option>";
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

    public function actionGetAttributes($subject) {
        if (Yii::$app->request->getIsPost()) {

            if ($subject == 'se') {
                $attributes= array(""=>"Jumlah Masuk",""=>"Jumlah Survived",""=>"Survival Rate");
                foreach ($attributes as $key => $value) {

                    echo "<option value='" . $key. "'>" . $value . "</option>";
                }
            } else {
                if($subject=='su'){
                     attributesValue = ["Jumlah Akhir Tahun", "Jumlah Survived", "Survival Rate"];
                }else{//subject=='ju
                   attributesValue = ["Jumlah Masuk", "Jumlah Keluar", "Jumlah Awal Tahun", "Jumlah Aktif Beroperasi", "Jumlah Akhir Tahun", "Perubahan"];   
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

    public function actionView() {
        return $this->render('view', [
        ]);
    }

}
