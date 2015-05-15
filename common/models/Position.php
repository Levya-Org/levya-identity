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
            [['POSITION_NAME', 'POSITION_LEVEL', 'POSITION_ISOBLIGATORY', 'POSITION_NEEDDONATION', 'POSITION_NEEDSUBSCRIPTION', 'PROJECT_PROJECT_ID'], 'required'],
            [['POSITION_DESCRIPTION'], 'string'],
            [['POSITION_ISOBLIGATORY', 'POSITION_ISDELETED', 'POSITION_NEEDDONATION', 'POSITION_NEEDSUBSCRIPTION'], 'boolean'],
            [['PROJECT_PROJECT_ID', 'POSITION_LEVEL'], 'integer'],
            [['POSITION_NAME'], 'string', 'max' => 45]
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
            'PROJECT_PROJECT_ID' => Yii::t('app/position', 'Project  Project  ID'),
        ];
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
}
