<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\SearchUser;
use frontend\models\RoleForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;

//use frontend\models\ResetPasswordForm;

/**
 * UserEditController implements the CRUD actions for User model.
 */
class ManageUserController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'editPassword', 'delete'],
                'rules' => [
                    [
                        'actions' => ['view', 'update', 'editPassword'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['editRole', 'index', 'delete'],
                        'allow' => true,
                        'roles' => ['manageUsers'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        if (Yii::$app->user->can('manageUsers')) {
            $searchModel = new SearchUser();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            Yii::$app->session->setFlash('warning', 'You do not have permission to access this page.');
            return $this->goHome();
        }
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $idSuppose = \Yii::$app->user->identity->id;
        if ($model->id == $idSuppose || \Yii::$app->user->can('manageUsers')) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'You have updated this profile.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        } else {
            Yii::$app->session->setFlash('warning', 'You do not have permission to access this page.');
            return $this->goHome();
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        if (Yii::$app->user->can('manageUsers')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('warning', 'You do not have permission to access this page.');
            return $this->goHome();
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

//    public function actionChangePassword() {
//        $model = new PasswordResetRequestForm();
//        $model->email = Yii::$app->user->identity->email;
//        if ($model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
//
//                return $this->goHome();
//            } else {
//                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
//            }
//        }
//    }
    public function actionChangePassword($id) {//menggunakan reset password form
        $model = new PasswordResetRequestForm();

        $model->email = $this->findModel($id)->email; //email dari user yang dipilih, bukan user yang aktif.
        //$model->email = Yii::$app->user->identity->email; //email dari user yang aktif
        if ($model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }
    }

}
