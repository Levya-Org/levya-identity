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

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\ActionHistorySearch;

use common\models\User;
use common\helpers\RoleHelper;
use frontend\models\ProfileForm_Update;

class ProfileController extends \yii\web\Controller
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
                        'actions' => ['index', 'update', 'view', 'view-raw', 'cnil-pdelete', 'cnil-fdelete', 'action-history'],
                        'roles' => ['@']
                    ],
                ]
            ],
        ];
    }
    
    public function actionActionHistory()
    {
        $searchModel = new ActionHistorySearch();
        $searchModel->USER_USER_ID = \Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('action-history', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return type
     */
    public function actionUpdate()
    {
        $profile = ProfileForm_Update::findIdentity(\Yii::$app->user->id);
        
        if(RoleHelper::userHasRole($profile->USER_ID, RoleHelper::ROLE_MEMBER))
            $profile->setScenario('user_AsMember_settings');
        else
            $profile->setScenario('user_settings');
        
        if ($profile->load(Yii::$app->request->post()) && $profile->updateProfile()) {
            return $this->redirect(['view', 'id' => $profile->USER_ID]);
        } else {
            return $this->render('update', [
                'model' => $profile,
            ]);
        }
    }

    public function actionView()
    {
        $model = $this->findUser(\Yii::$app->user->id);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionViewRaw($token)
    {
        $model = $this->findUser(\Yii::$app->user->id);
        
        if($model->confirmToken($token)){
            \Yii::$app->session->setFlash('user.cnil-raw_ok');
        } 
        else {
            \Yii::$app->session->setFlash('user.cnil-raw_ko');
            $model = new common\models\User();
        }
        
        return $this->render('view-raw', [
            'model' => $model,
        ]);
    }
    
    public function actionCnilPdelete($token)
    {
        $model = $this->findUser(\Yii::$app->user->id);
        
        if($model->confirmToken($token)){
            $model->cnilFullDelete();
            \Yii::$app->session->setFlash('user.cnil-pdelete_ok');
        } 
        else {
            \Yii::$app->session->setFlash('user.cnil-pdelete_ko');
        }
        
        return $this->render('cnil-pdelete');
    }
    
    public function actionCnilFdelete($token)
    {
        $model = $this->findUser(\Yii::$app->user->id);
        
        if($model->confirmToken($token)){
            $model->cnilFullDelete();
            \Yii::$app->session->setFlash('user.cnil-fdelete_ok');
        }
        else {
            \Yii::$app->session->setFlash('user.cnil-pdelete_ko');
        }
        
        return $this->render('cnil-fdelete');
    }
    
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
