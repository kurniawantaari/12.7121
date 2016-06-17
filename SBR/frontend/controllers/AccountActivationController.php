<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use frontend\models\AccountActivationForm;

/**
 * Account Activation controller
 */
class AccountActivationController extends Controller {
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

    /**
     * Activate account
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionAccountActivation($token) {
        try {
            $model = new AccountActivationForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->activateAccount()) {
            Yii::$app->session->setFlash('success', 'Account is activated.');

            return $this->goHome();
        }

        return $this->render('accountActivation', [
                    'model' => $model,
        ]);
    }
}
