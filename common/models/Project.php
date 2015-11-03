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

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\log\Logger;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use common\helpers\LDAPHelper;
use common\helpers\RoleHelper;

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
        return $this->hasMany(Donation::className(), ['PROJECT_PROJECT_ID' => 'PROJECT_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Positions()
    {
        return $this->hasMany(Position::className(), ['PROJECT_PROJECT_ID' => 'PROJECT_ID'])->where(['POSITION_ISDELETED' => false])->orderBy('POSITION_LEVEL');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Works()
    {
        return $this->hasMany(Work::className(), ['PROJECT_PROJECT_ID' => 'PROJECT_ID']);
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
     * Create a Project with default position
     * Do RBAC assignement
     * TODO: Project Position Name I18N / Param
     * @param type $userId
     * @return boolean
     * @throws \RuntimeException
     * @throws \common\models\Exception
     * @throws \ErrorException
     */
    public function create($userId = null){
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing Project');
        }
        
        if(!isset($userId)){
            $userId = Yii::$app->user->id;
        }
        
        $transaction = $this->getDb()->beginTransaction();
        
        try {            
            if ($this->save()) {
                \Yii::getLogger()->log('Project has been created', Logger::LEVEL_INFO);
                
                //POSITION
                {
                    //LEADER
                    {
                        $position = new Position([
                            'scenario' => 'position_create',
                            'POSITION_LEVEL' => 0,
                            'POSITION_NAME' => "Project Leader",
                            'POSITION_ISOBLIGATORY' => true,
                            'POSITION_NEEDDONATION' => false,
                            'POSITION_NEEDSUBSCRIPTION' => false,
                            'PROJECT_PROJECT_ID' => $this->primaryKey
                        ]);
                        $position->create();
                        $position->addUser($userId, true);
                        
                        //Leader has access to all services
                        $services = Service::getServicesList();
                        foreach ($services as $key => $value) {
                            $position->addService($key);
                        }
                    }
                    //MEMBER
                    {
                        $position = new Position([
                            'scenario' => 'position_create',
                            'POSITION_LEVEL' => 1,
                            'POSITION_NAME' => "Project Member",
                            'POSITION_ISOBLIGATORY' => false,
                            'POSITION_NEEDDONATION' => false,
                            'POSITION_NEEDSUBSCRIPTION' => false,
                            'PROJECT_PROJECT_ID' => $this->primaryKey
                        ]);
                        $position->create();
                    }
                    //GUEST
                    {
                        $position = new Position([
                            'scenario' => 'position_create',
                            'POSITION_LEVEL' => 2,
                            'POSITION_NAME' => "Project Guest",
                            'POSITION_ISOBLIGATORY' => false,
                            'POSITION_NEEDDONATION' => false,
                            'POSITION_NEEDSUBSCRIPTION' => false,
                            'PROJECT_PROJECT_ID' => $this->primaryKey
                        ]);
                        $position->create();
                    }
                }
                //RBAC LEADER
                {
                    if(!RoleHelper::userHasRole($userId, RoleHelper::ROLE_PROJECT_LEADER)){
                        $projectLeader = \Yii::$app->authManager->getRole('project.leader');
                        \Yii::$app->authManager->assign($projectLeader, $userId);   
                    }                                   
                }
                //LDAP
                {
                    $ldap = new LDAPHelper();
                    //TODO
                }
                
                $transaction->commit();
                return true;
            }
            else {
                \Yii::getLogger()->log('Project hasn\'t been created'.VarDumper::dumpAsString($this->errors), Logger::LEVEL_WARNING);
                throw  new \ErrorException('Project error at creation, see Model error.');
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            \Yii::getLogger()->log('An error occurred while creating a Project '.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
            throw $ex;
        }
        return false;
    }
    
    /**
     * Return an array of all projects
     * @return array[PROJECT_ID,PROJECT_NAME]
     */
    public static function getProjectsList()
    {
        return ArrayHelper::map(Project::findAll(['PROJECT_ISDELETED' => 0]), 'PROJECT_ID', 'PROJECT_NAME');
    }
    
    /**
     * Return default Position of this Project
     * @return \common\models\Position
     */
    public function  getDefaultPosition(){
        foreach ($this->r_Positions as $position) {
            if($position->POSITION_ISDEFAULT)
                return $position;
        }
    }
}
