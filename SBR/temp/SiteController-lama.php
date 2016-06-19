<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\AccountActivation;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\EditUsernameForm;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'about'],
                'rules' => [ [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['about'],
                        'allow' => true,
                        'roles' => ['manageGivenTable'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionGenerateTable() {
        return $this->render('generateTable');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                //edited
                //uncomment this after admin is created
                $email = Yii::$app
                        ->mailer
                        ->compose(
                                ['html' => 'accountActivationToken-html', 'text' => 'accountActivationToken-text'], ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                        ->setTo($user->email)
                        ->setSubject(Yii::$app->name . ':Sign Up Confirmation')
                        ->send();
                if ($email) {
                    Yii::$app->getSession()->setFlash('success', 'Sign Up success. Check your email to activate your account!');
                } else {
                    Yii::$app->getSession()->setFlash('warning', 'Sign Up failed. Please try again or contact administrator.');
                }
                //end-edited
//                if (Yii::$app->getUser()->login($user)) {
                return $this->goHome();
//                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

//    public function actionAccountActivation($token) {//modified dengan tutorial di internet. berhasil mengaktifkan user
//        $user = \common\models\User::find()->where([
//                    'account_activation_token' => $token,
//                    'status' => 5,
//                ])->one();
//        if (!empty($user)) {
//            $user->status = 10;
//            $user->account_activation_token=null;
//            $user->save();
//            Yii::$app->session->setFlash('success', 'Account is activated.');
//        } else {
//            Yii::$app->getSession()->setFlash('warning', 'Failed to activate account. Account Activation token might be invalid.');
//        }
//        return $this->goHome();
//    }

    public function actionAccountActivation($token) {
        try {
            $model = new AccountActivation($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->accountActivation()) {
            Yii::$app->session->setFlash('success', 'Account is activated.');

            return $this->goHome();
        }

        return $this->render('accountActivation', [
                    'model' => $model,
        ]);
    }

//    public function actionRequestAccountActivation() {
//        $model = new AccountActivationRequestForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
//                return $this->goHome();
//            } else {
//                Yii::$app->session->setFlash('error', 'Sorry, we are unable to proceed your account activation request for email provided.');
//            }
//        }
//
//        return $this->render('requestAccountActivationToken', [
//                    'model' => $model,
//        ]);
//    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAccountDetail() {
        $modelUsername = new EditUsernameForm();
        if ($modelUsername->load(Yii::$app->request->post())) {
            if ($user = $modelUsername->saveUsername()) {
                Yii::$app->session->setFlash('success', 'Username changed.');
            }
        }
    }

}
