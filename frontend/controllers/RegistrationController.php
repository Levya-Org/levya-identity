<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use frontend\models\RegisterForm_Resend;
use frontend\models\RegisterForm_Register;
use frontend\models\RegisterForm_RegisterAsMember;
use common\helpers\LDAPHelper;

class RegistrationController extends Controller
{
    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['register','confirm', 'resend'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['register-member'],
                        'roles' => ['@']
                    ],
                ]
            ],
        ];
    }

    public function actionConfirm($mail, $token)
    {
        $user = \common\models\User::findByMail($mail);
        if ($user === null || \Yii::$app->params['registration:enableConfirmation'] == false) {
            throw new NotFoundHttpException;
        }
        
        if ($user->confirmToken($token)) {
            \Yii::$app->session->setFlash('user.confirmation_finished');
        }
        else {
            \Yii::$app->session->setFlash('user.invalid_token');
        }
        
        return $this->render('finish');
    }

    public function actionRegister()
    {       
        $model = new RegisterForm_Register();

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            return $this->render('finish');
        }

        return $this->render('register', [
            'model' => $model
        ]);
    }
    
    public function actionRegisterMember()
    {       
        $model = RegisterForm_RegisterAsMember::findIdentity(\Yii::$app->user->id);

        if ($model->load(\Yii::$app->request->post()) && $model->registerAsMember()) {
            return $this->render('finish');
        }

        return $this->render('registerAsMember', [
            'model' => $model
        ]);
    }

    public function actionResend()
    {
        $model = new RegisterForm_Resend();
        
        if ($model->load(\Yii::$app->request->post()) && $model->resend()) {
            return $this->render('finish');
        }
        
        return $this->render('resend', [
            'model' => $model
        ]);
    }
}
