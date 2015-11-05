<?php
/**
 * This file is part of Levya Identity.
 * 
 * Levya Identity is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Foobar. See file LICENSE(.md) in this source tree, 
 * if not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (C) Levya Team Members
 */

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
                        'actions' => ['register'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['confirm', 'resend'],
                        'roles' => ['?','@']
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
        $model->setScenario('user_AsMember_register');

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
