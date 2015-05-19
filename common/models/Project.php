<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\log\Logger;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "PROJECT".
 *
 * @property integer $PROJECT_ID
 * @property string $PROJECT_NAME
 * @property string $PROJECT_DESCRIPTION
 * @property string $PROJECT_WEBSITE
 * @property string $PROJECT_LOGO
 * @property string $PROJECT_CREATIONDATE
 * @property string $PROJECT_UPDATEDATE
 * @property integer $PROJECT_ISACTIVE
 * @property integer $PROJECT_ISDELETED
 * @property integer $PROJECT_ISOPEN
 * @property integer $PROJECT_PRIORITY
 *
 * @property DONATION[] $r_Donations
 * @property POSITION[] $r_Positions
 * @property WORK[] $r_Works
 * @property USER[] $r_UserRequests
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PROJECT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PROJECT_NAME', 'PROJECT_DESCRIPTION', 'PROJECT_WEBSITE', 'PROJECT_ISACTIVE', 'PROJECT_ISDELETED', 'PROJECT_ISOPEN'], 'required'],
            [['PROJECT_NAME', 'PROJECT_DESCRIPTION', 'PROJECT_WEBSITE', 'PROJECT_CREATIONDATE', 'PROJECT_ISACTIVE', 'PROJECT_ISDELETED', 'PROJECT_ISOPEN'], 'safe'],
            
            //NAME
            [['PROJECT_NAME'], 'unique'],
            [['PROJECT_NAME'], 'string', 'max' => 100],            
    
            [['PROJECT_DESCRIPTION'], 'string'],
            
            [['PROJECT_WEBSITE'], 'string', 'max' => 200],
            [['PROJECT_WEBSITE'], 'url'],
            
            [['PROJECT_PRIORITY'], 'integer', 'min' => 0, 'max' => 128],
            
            [['PROJECT_ISACTIVE', 'PROJECT_ISDELETED', 'PROJECT_ISOPEN'], 'boolean'],
            [['PROJECT_ISDELETED'], 'default', 'value' => false],
            
            [['PROJECT_LOGO'], 'string', 'max' => 50],            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PROJECT_ID' => Yii::t('app/project', 'Project  ID'),
            'PROJECT_NAME' => Yii::t('app/project', 'Project  Name'),
            'PROJECT_DESCRIPTION' => Yii::t('app/project', 'Project  Description'),
            'PROJECT_WEBSITE' => Yii::t('app/project', 'Project  Website'),
            'PROJECT_LOGO' => Yii::t('app/project', 'Project  Logo'),
            'PROJECT_CREATIONDATE' => Yii::t('app/project', 'Project  Creationdate'),
            'PROJECT_UPDATEDATE' => Yii::t('app/project', 'Project  Updatedate'),
            'PROJECT_ISACTIVE' => Yii::t('app/project', 'Project  Isactive'),
            'PROJECT_ISDELETED' => Yii::t('app/project', 'Project  Isdeleted'),
            'PROJECT_ISOPEN' => Yii::t('app/project', 'Project  Isopen'),
            'PROJECT_PRIORITY' => Yii::t('app/project', 'Project  Priority'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['PROJECT_NAME', 'PROJECT_DESCRIPTION', 'PROJECT_WEBSITE', 'PROJECT_CREATIONDATE', 'PROJECT_ISACTIVE', 'PROJECT_ISDELETED', 'PROJECT_ISOPEN'],
            'update' => ['PROJECT_NAME', 'PROJECT_DESCRIPTION', 'PROJECT_WEBSITE', 'PROJECT_CREATIONDATE', 'PROJECT_ISACTIVE', 'PROJECT_ISDELETED', 'PROJECT_ISOPEN'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'PROJECT_CREATIONDATE',
                'updatedAtAttribute' => 'PROJECT_UPDATEDATE',
                'value' =>  new Expression('NOW()')
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Donations()
    {
        return $this->hasMany(DONATION::className(), ['PROJECT_PROJECT_ID' => 'PROJECT_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Positions()
    {
        return $this->hasMany(POSITION::className(), ['PROJECT_PROJECT_ID' => 'PROJECT_ID'])->where(['POSITION_ISDELETED' => false])->orderBy('POSITION_LEVEL');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Works()
    {
        return $this->hasMany(WORK::className(), ['PROJECT_PROJECT_ID' => 'PROJECT_ID']);
    }
    
    /**
     * Return all membership request
     * @return \yii\db\ActiveQuery
     */
    public function getr_UserRequests(){
        return $this->hasMany(User::className(), ['USER_ID' => 'USER_USER_ID'])                
                ->viaTable(Work::tableName(), ['PROJECT_PROJECT_ID' => 'PROJECT_ID'], function($query) {
                          $query->onCondition([
                              'WORK_TO' => null,
                              'WORK_ISACCEPTED' => false                            
                            ]);
                      });
//                ->select(['*']);
    }
    
    /**
     * Return an array of all projects
     * @return array[PROJECT_ID,PROJECT_NAME]
     */
    public static function getProjectsList()
    {
        return ArrayHelper::map(Project::findAll(['PROJECT_ISDELETED' => 0]), 'PROJECT_ID', 'PROJECT_NAME');
    }
}
