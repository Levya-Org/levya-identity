<?php

namespace common\models;

use Yii;
use yii\log\Logger;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "POSITION".
 *
 * @property integer $POSITION_ID
 * @property integer $POSITION_LEVEL 
 * @property string $POSITION_NAME
 * @property string $POSITION_DESCRIPTION
 * @property integer $POSITION_ISOBLIGATORY
 * @property integer $POSITION_ISDELETED
 * @property integer $POSITION_NEEDDONATION
 * @property integer $POSITION_NEEDSUBSCRIPTION
 * @property integer $POSITION_ISREQVISIBLE 
 * @property integer $POSITION_ISDEFAULT 
 * @property integer $PROJECT_PROJECT_ID
 *
 * @property PROJECT $r_Project
 * @property WORK[] $r_Works
 * @property SERVICE[] $r_Services
 * @property USER[] $r_Users Get Member
 * @property USER[] $r_UserRequests Get Member request
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'POSITION';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POSITION_NAME', 'POSITION_LEVEL', 'POSITION_ISOBLIGATORY', 'POSITION_NEEDDONATION', 'POSITION_NEEDSUBSCRIPTION', 'PROJECT_PROJECT_ID', 'POSITION_ISDEFAULT'], 'required'],
            [['POSITION_DESCRIPTION'], 'string'],
            [['POSITION_ISOBLIGATORY', 'POSITION_ISDELETED', 'POSITION_NEEDDONATION', 'POSITION_NEEDSUBSCRIPTION', 'POSITION_ISDEFAULT'], 'boolean'],
            [['PROJECT_PROJECT_ID', 'POSITION_LEVEL'], 'integer'],
            ['PROJECT_PROJECT_ID', 'exist', 'targetClass' => 'common\models\PROJECT', 'targetAttribute' => 'PROJECT_ID'],
            [['POSITION_NAME'], 'string', 'max' => 45],
            
            [['POSITION_NAME', 'POSITION_LEVEL'], 'validePosition']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POSITION_ID' => Yii::t('app/position', 'Position  ID'),
            'POSITION_LEVEL' => Yii::t('app/position', 'Position  Level'),
            'POSITION_NAME' => Yii::t('app/position', 'Position  Name'),
            'POSITION_DESCRIPTION' => Yii::t('app/position', 'Position  Description'),
            'POSITION_ISOBLIGATORY' => Yii::t('app/position', 'Position  Isobligatory'),
            'POSITION_ISDELETED' => Yii::t('app/position', 'Position  Isdeleted'),
            'POSITION_NEEDDONATION' => Yii::t('app/position', 'Position  Needdonation'),
            'POSITION_NEEDSUBSCRIPTION' => Yii::t('app/position', 'Position  Needsubscription'),
            'POSITION_ISREQVISIBLE' => Yii::t('app/geodata', 'Position is request visible'),
            'POSITION_ISDEFAULT' => Yii::t('app/geodata', 'Position Isdefault'),
            'PROJECT_PROJECT_ID' => Yii::t('app/position', 'Project  Project  ID'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios() {
        return [
            'position_create' => ['POSITION_NAME', 'POSITION_LEVEL', 'POSITION_ISOBLIGATORY', 'POSITION_NEEDDONATION', 'POSITION_NEEDSUBSCRIPTION', 'POSITION_ISREQVISIBLE', 'POSITION_ISDEFAULT', 'PROJECT_PROJECT_ID'],
            'position_update' => ['POSITION_NAME', 'POSITION_LEVEL', 'POSITION_ISOBLIGATORY', 'POSITION_NEEDDONATION', 'POSITION_NEEDSUBSCRIPTION', 'POSITION_ISREQVISIBLE', 'POSITION_ISDEFAULT', 'PROJECT_PROJECT_ID'],
        ];
    }

    public function validePosition($attribute,$params){
        switch ($attribute){
            case 'POSITION_NAME':{
                $position = Position::findOne([
                    'POSITION_ISDELETED' => 0,
                    'POSITION_NAME' => $this->POSITION_NAME,
                    'PROJECT_PROJECT_ID' => $this->PROJECT_PROJECT_ID
                ]);
                if($position && $this->POSITION_ID != $position->POSITION_ID)
                    $this->addError ($attribute, 'Name must be unique');
                break;
            }
            case 'POSITION_LEVEL':{
                $position = Position::findOne([
                    'POSITION_ISDELETED' => 0,
                    'POSITION_LEVEL' => $this->POSITION_LEVEL,
                    'PROJECT_PROJECT_ID' => $this->PROJECT_PROJECT_ID
                ]);
                if($position && $this->POSITION_ID != $position->POSITION_ID)
                    $this->addError ($attribute, 'An another Position has same level');
                break;
            }
            default:{
                \Yii::getLogger()->log('Validating an unknown attribute : '.$attribute, Logger::LEVEL_WARNING); 
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Project()
    {
        return $this->hasOne(PROJECT::className(), ['PROJECT_ID' => 'PROJECT_PROJECT_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Works()
    {
        return $this->hasMany(WORK::className(), ['POSITION_POSITION_ID' => 'POSITION_ID']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Services()
    {
        return $this->hasMany(Service::className(), ['SERVICE_ID' => 'SERVICE_SERVICE_ID'])
                ->viaTable(PositionAccessService::tableName(), ['POSITION_POSITION_ID' => 'POSITION_ID']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Users(){
        return $this->hasMany(User::className(), ['USER_ID' => 'USER_USER_ID'])                
                ->viaTable(Work::tableName(), ['POSITION_POSITION_ID' => 'POSITION_ID'], function($query) {
                          $query->onCondition([
                              'WORK_TO' => null,
                              'WORK_ISACCEPTED' => true                            
                            ]);
                      });
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_UserRequests(){
        return $this->hasMany(User::className(), ['USER_ID' => 'USER_USER_ID'])                
                ->viaTable(Work::tableName(), ['POSITION_POSITION_ID' => 'POSITION_ID'], function($query) {
                          $query->onCondition([
                              'WORK_TO' => null,
                              'WORK_ISACCEPTED' => false                            
                            ]);
                      });
    }
    
    /**
     * Is Position active or not
     * @return boolean
     */
    public function isActive(){
        return !$this->POSITION_ISDELETED;
    }
    
    /**
     * Return an array of all position
     * @return array[POSITION_ID,POSITION_NAME]
     */
    public static function getAllPositionsList()
    {
        return ArrayHelper::map(Position::findAll(), 'POSITION_ID', 'POSITION_NAME');
    }
    
    /**
     * Return an array of all (active) positions in project
     * @return array[POSITION_ID,POSITION_NAME]
     */
    public static function getPositionsListByProject($projectId)
    {
        return ArrayHelper::map(Position::findAll(['POSITION_ISDELETED' => 0, 'PROJECT_PROJECT_ID' => $projectId]), 'POSITION_ID', 'POSITION_NAME');
    }
    
    /**
     * Return an array of all (active) positions in project without the specified
     * @return array[POSITION_ID,POSITION_NAME]
     */
    public static function getPositionsListByProjectAndLevel($projectId, $level)
    {
        $query = Position::find()
                ->where(['POSITION_ISDELETED' => 0, 'PROJECT_PROJECT_ID' => $projectId])
                ->andWhere('POSITION_LEVEL != :level', [':level' => $level])
                ->all();
        return ArrayHelper::map($query, 'POSITION_ID', 'POSITION_NAME');
    }
    
    /**
     * Create a Position
     * @return boolean
     * @throws \RuntimeException
     * @throws \common\models\Exception
     * @throws \ErrorException
     */
    public function create(){
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing Position');
        }
        
        $transaction = $this->getDb()->beginTransaction();
        
        try {            
            if ($this->save()) {
                \Yii::getLogger()->log('Position has been created', Logger::LEVEL_INFO);
                $transaction->commit();
                return true;
            }
            else {
                \Yii::getLogger()->log('Position hasn\'t been created'.VarDumper::dumpAsString($this->errors), Logger::LEVEL_WARNING);
                throw  new \ErrorException('Position error at creation, see Model error.');
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            \Yii::getLogger()->log('An error occurred while creating a Position'.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
            throw $ex;
        }
        return false;
    }
    
    /**
     * Add a User to Project with a Position
     * @param int $userId
     * @param bool $locked If Project Leader
     * @return type
     */
    public function addUser($userId, $locked = false){
        if(!isset($userId)){
            \Yii::getLogger()->log('Position->addUser called without userId param', Logger::LEVEL_ERROR);
            return;
        }
        
        $work = new Work([
            'USER_USER_ID' => $userId,
            'PROJECT_PROJECT_ID' => $this->PROJECT_PROJECT_ID,                                      
            'POSITION_POSITION_ID' => $this->POSITION_ID,
            'WORK_ISACCEPTED' => true,
            'WORK_ISLOCKED' => $locked
        ]);
        $work->create();
    }
    
    /**
     * Remove a User to Project with a Position
     * @param type $userId
     * @return type
     */
    public function removeUser($userId){
        if(!isset($userId)){
            \Yii::getLogger()->log('Position->removeUser called without userId param', Logger::LEVEL_ERROR);
            return;
        }
        
        Work::findOne([
            'USER_USER_ID' => $userId,
            'PROJECT_PROJECT_ID' => $this->PROJECT_PROJECT_ID,
            'POSITION_POSITION_ID' => $this->POSITION_ID,
            'WORK_TO' => null ,
            'WORK_ISACCEPTED' => true,
        ])->endWork();  
    }
    
    /**
     * Add a service to the Position
     * @param int $serviceId
     * @return boolean
     */
    public function addService($serviceId){
        if(!isset($serviceId)){
            \Yii::getLogger()->log('Position->addService called without serviceId param', Logger::LEVEL_ERROR);
            return;
        }
        
        $pas = new PositionAccessService([
            'SERVICE_SERVICE_ID' => $serviceId,
            'POSITION_POSITION_ID' => $this->POSITION_ID
        ]);
        return $pas->create();
    }
    
    /**
     * Remove a service from the Position
     * @param int $serviceId
     * @return type
     */
    public function removeService($serviceId){
        if(!isset($serviceId)){
            \Yii::getLogger()->log('Position->addService called without serviceId param', Logger::LEVEL_ERROR);
            return;
        }
        
        PositionAccessService::deleteAll([
            'SERVICE_SERVICE_ID' => $serviceId,
            'POSITION_POSITION_ID' => $this->POSITION_ID
        ]);
    }
}
