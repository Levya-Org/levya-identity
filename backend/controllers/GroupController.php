<?php

namespace app\controllers;

use Yii;
use app\models\Group;
use app\models\GroupSearch;
use app\models\GroupAccessService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ConflictHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\log\Logger;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
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
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
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
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->GROUP_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->GROUP_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Group model.
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
            $selectedService = \Yii::$app->request->post('service');
            //From Grid
            $selectedServices = \Yii::$app->request->post('selection');
            $groupId = \Yii::$app->request->post('group_id');
            
            if(!isset($action)){
                \Yii::getLogger()->log('actionAjaxUpdate called without action param', Logger::LEVEL_ERROR);
                throw new ConflictHttpException();
            }
                
            if(!isset($groupId)){
               \Yii::getLogger()->log('actionAjaxUpdate called without GroupID param', Logger::LEVEL_ERROR);
               throw new ConflictHttpException();
            }                
            
            if($action == "doAdd"){
                $model = new GroupAccessService([
                    'GROUP_GROUP_ID' => $groupId,
                    'SERVICE_SERVICE_ID' => $selectedService
                ]);
                $model->save();
            }
                        
            if (count($selectedServices) > 0) {
                foreach ($selectedServices as $service) {                    
                    switch ($action) {
                        case "doAdd" : {
                                break;
                            }
                        case "doRemove" : {
                                $model = GroupAccessService::findOne(
                                    [
                                        'GROUP_GROUP_ID' => $groupId,
                                        'SERVICE_SERVICE_ID' => $service
                                    ]);
                                if($model != null)
                                    $model->delete ();
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
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
