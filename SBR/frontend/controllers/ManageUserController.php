<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\SearchUser;
use frontend\models\EditPasswordForm;
use frontend\models\EditRoleForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                'only' => ['index','view', 'update', 'editPassword','editRole'],
                'rules' => [ 
                    [
                        'actions' => ['view','update','editPassword'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['editRole','index'],
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
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
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
              if ($model->id == $idSuppose||\Yii::$app->user->can('manageUsers')) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'You have updated this profile.');
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
        }else{
            Yii::$app->session->setFlash('danger', 'You can not update another user profile.');
            return $this->goHome();
        }
        
    }

    public function actionEditPassword($id) {
        $model = new EditPasswordForm($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveNewPassword()) {
            Yii::$app->session->setFlash('success', 'Password changed.');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('update', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionEditRole($id) {
        $model = new EditRoleForm($id);
        //$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->changeRole()) {
            Yii::$app->session->setFlash('success', 'Role changed.');
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('update', [
                        'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

}
