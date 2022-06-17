<?php

namespace factory\modules\profilemanager\controllers;

use factory\modules\profilemanager\models\ChangePasswordForm;
use factory\modules\profilemanager\models\ProfileUser;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `profilemanager` module
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['factory'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-account' => ['POST'],
                ]
            ]
        ];
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionChangeLogin()
    {
        $model = ProfileUser::getUserModel();
        if (!$model){
             throw new NotFoundHttpException(Yii::t('app', 'Page not found'));
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Shaxsiy ma'lumotlaringiz muvaffaqiyatli o'zgartirildi!");
            return $this->redirect(['index']);
        }
        return $this->render('update' ,['model' => $model]);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->savePassword()) {

            Yii::$app->session->setFlash('success', "Parolingiz muvaffaqiyatli o'zgartirildi!");
            return $this->redirect(['index']);

        }
        return $this->render('changePassword' ,['model' => $model]);
    }
}
