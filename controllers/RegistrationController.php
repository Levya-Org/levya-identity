<?php
namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\RegisterForm_Resend;
use app\models\RegisterForm_Register;
use app\models\RegisterForm_RegisterAsMember;

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
                        'actions' => ['register', 'register-member'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['confirm', 'resend'],
                        'roles' => ['?', '@']
                    ],
                ]
            ],
        ];
    }

    public function actionConfirm($id, $token)
    {
        $user = \app\models\User::findIdentity($id);
        if ($user === null || \Yii::$app->params['registration:enableConfirmation'] == false) {
            throw new NotFoundHttpException;
        }
        
        if ($user->confirm($token)) {
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
        $model = new RegisterForm_RegisterAsMember();

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
