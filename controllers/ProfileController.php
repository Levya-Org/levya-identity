<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\ActionHistorySearch;

use app\models\User;
use app\models\ProfileForm_Update;
use app\helpers\RoleHelper;

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
                        'actions' => ['index', 'update', 'view', 'view-raw', 'action-history'],
                        'roles' => ['@']
                    ],
                ]
            ],
        ];
    }
    
    //TODO: add orderby HistoryDate
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

    public function actionViewRaw()
    {
        return $this->render('view-raw');
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
