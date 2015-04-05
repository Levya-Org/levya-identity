<?php

namespace backend\controllers;

use Yii;
use common\models\Position;
use common\models\PositionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\log\Logger;
use yii\helpers\VarDumper;

use common\models\PositionAccessService;

/**
 * PositionController implements the CRUD actions for Position model.
 */
class PositionController extends Controller
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
     * Lists all Position models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PositionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Position model.
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
     * Creates a new Position model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Position();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->POSITION_ID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Position model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->POSITION_ID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Position model.
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
            $positionId = \Yii::$app->request->post('position_id');
            
            if(!isset($action)){
                \Yii::getLogger()->log('actionAjaxUpdate called without action param', Logger::LEVEL_ERROR);
                throw new ConflictHttpException();
            }
                
            if(!isset($positionId)){
               \Yii::getLogger()->log('actionAjaxUpdate called without PositionID param', Logger::LEVEL_ERROR);
               throw new ConflictHttpException();
            }                
            
            if($action == "doAdd"){
                $model = new PositionAccessService([
                    'POSITION_POSITION_ID' => $positionId,
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
                                PositionAccessService::deleteAll([
                                    'POSITION_POSITION_ID' => $positionId,
                                    'SERVICE_SERVICE_ID' => $service
                                ]);
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
     * Finds the Position model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Position the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Position::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
