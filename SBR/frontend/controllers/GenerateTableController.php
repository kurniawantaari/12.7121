<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
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

    
    public function actionIndexTemp() {
        
        //$connection = \yii\db\Connection();
        //$connection->open();
        //  $dummy = $connection->createCommand('SELECT * FROM dummy')->queryAll();
        $dataProvider = new SqlDataProvider([
    'sql' => 'SELECT * FROM dummy',
    ]);
      return $this->render('tesTable');
        
        
    }
    public function actionIndex()
    {
        $dataProvider = new SqlDataProvider([
    'sql' => 'SELECT * FROM dummy',
    ]);

        return $this->render('tesTable', [
                        'dataProvider' => $dataProvider,
        ]);
    }
}