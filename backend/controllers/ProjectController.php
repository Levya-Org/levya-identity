<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ConflictHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\log\Logger;
use yii\helpers\VarDumper;

use common\models\Project;
use common\models\ProjectSearch;
use common\models\Work;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'AjaxUpdate'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'AjaxUpdate'],
                        'roles' => ['administrator', 'developer'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();
        $model->setScenario('create');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->PROJECT_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->PROJECT_ID]);
        } else {
             \Yii::getLogger()->log('Project not updated '.VarDumper::dumpAsString($model->errors), Logger::LEVEL_WARNING);
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    /**
     * Function used only with/for ajax call.
     * @throws ConflictHttpException
     * @throws NotFoundHttpException
     */
    public function actionAjaxUpdate(){
        if(\Yii::$app->request->isAjax){
            \Yii::getLogger()->log('actionAjaxUpdate', Logger::LEVEL_TRACE);
            //Action
            $action = \Yii::$app->request->post('action');
            //From DropdownList
            $selectedPosition = \Yii::$app->request->post('selected_position_id');
            //From hidde,Input
            $projectId = \Yii::$app->request->post('project_id');
            $workingPosition = \Yii::$app->request->post('working_position_id');
            //From Grid
            $selectedUsers = \Yii::$app->request->post('selection');         
            
            if(!isset($action)){
                \Yii::getLogger()->log('actionAjaxUpdate called without action param', Logger::LEVEL_ERROR);
                throw new ConflictHttpException();
            }
                
            if(!isset($selectedPosition)){
               \Yii::getLogger()->log('actionAjaxUpdate called without selectedPosition param', Logger::LEVEL_ERROR);
               throw new ConflictHttpException();
            } 
            
            if(!isset($workingPosition)){
               \Yii::getLogger()->log('actionAjaxUpdate called without workingPosition param', Logger::LEVEL_ERROR);
               throw new ConflictHttpException();
            }
            
            if(!isset($projectId)){
               \Yii::getLogger()->log('actionAjaxUpdate called without projectId param', Logger::LEVEL_ERROR);
               throw new ConflictHttpException();
            }
                        
            if (count($selectedUsers) > 0) {
                foreach ($selectedUsers as $user) {                    
                    switch ($action) {
                        case "doNominateMember" : {
                            Work::endWorkToNewPosition($user, $projectId, $workingPosition, $selectedPosition);
                            break;
                        }
                        case "doDismissMember" : {
                                Work::findOne([
                                    'USER_USER_ID' => $user,
                                    'PROJECT_PROJECT_ID' => $projectId,
                                    'POSITION_POSITION_ID' => $workingPosition,
                                    'WORK_TO' => null ,
                                    'WORK_ISACCEPTED' => true,
                                ])->endWork();                        
                            break;
                        }
                        case "doRefuseRequest" : {
                             $model = Work::findOne([
                                    'USER_USER_ID' => $user,
                                    'PROJECT_PROJECT_ID' => $projectId,
                                    'POSITION_POSITION_ID' => $workingPosition,
                                    'WORK_TO' => null ,
                                    'WORK_ISACCEPTED' => false,
                                ]);
                             $model->endWork(); 
                            break;
                        }
                        case "doAcceptRequest" : {
                            $model = Work::findOne([
                                    'USER_USER_ID' => $user,
                                    'PROJECT_PROJECT_ID' => $projectId,
                                    'POSITION_POSITION_ID' => $workingPosition,
                                    'WORK_TO' => null ,
                                    'WORK_ISACCEPTED' => false,
                                ]);
                            $model->validateWork();
                            break;
                        }
                        default : {
                                \Yii::getLogger()->log('actionAjaxUpdate called with an inexistent action', Logger::LEVEL_WARNING);
                                throw new NotFoundHttpException('The requested page does not exist.');
                            }
                    }
                }
            }
        }
        else 
            \Yii::getLogger()->log('actionAjaxUpdate called directly', Logger::LEVEL_WARNING);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
