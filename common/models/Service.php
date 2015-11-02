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
use \yii\helpers\ArrayHelper;

use common\models\GroupAccessService;
use common\models\Group;
use common\models\Belong;
use common\models\Position;
use common\models\PositionAccessService;
use common\models\Work;

/**
 * This is the model class for table "SERVICE".
 *
 * @property integer $SERVICE_ID
 * @property string $SERVICE_LDAPNAME
 * @property string $SERVICE_NAME
 * @property string $SERVICE_URL
 * @property string $SERVICE_DESCRIPTION
 * @property integer $SERVICE_ISENABLE
 * @property integer $SERVICE_STATE
 *
 * @property GROUP[] $r_Groups
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SERVICE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SERVICE_LDAPNAME', 'SERVICE_NAME', 'SERVICE_URL', 'SERVICE_DESCRIPTION', 'SERVICE_ISENABLE', 'SERVICE_STATE'], 'required'],
            [['SERVICE_URL'], 'url', 'defaultScheme' => 'https'],
            [['SERVICE_DESCRIPTION'], 'string'],
            [['SERVICE_ISENABLE', 'SERVICE_STATE'], 'integer'],
            [['SERVICE_LDAPNAME'], 'string', 'max' => 45],
            [['SERVICE_NAME'], 'string', 'max' => 225],
            
            [['SERVICE_NAME', 'SERVICE_LDAPNAME'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SERVICE_ID' => Yii::t('app/service', 'Service  ID'),
            'SERVICE_LDAPNAME' => Yii::t('app/service', 'Service  Ldapname'),
            'SERVICE_NAME' => Yii::t('app/service', 'Service  Name'),
            'SERVICE_URL' => Yii::t('app/service', 'Service  URL'),
            'SERVICE_DESCRIPTION' => Yii::t('app/service', 'Service  Description'),
            'SERVICE_ISENABLE' => Yii::t('app/service', 'Service  Isenable'),
            'SERVICE_STATE' => Yii::t('app/service', 'Service  State'),
        ];
    }
    
    /**
     * Return all Group(s) linked to this Service
     * @return \yii\db\ActiveQuery
     */
    public function getr_Groups(){
        return $this->hasMany(Group::className(), ['GROUP_ID' => 'GROUP_GROUP_ID'])
                ->viaTable(GroupAccessService::tableName(), ['SERVICE_SERVICE_ID' => 'SERVICE_ID']);
    }
    
    /**
     * Return an array of all services
     * @return array[SERVICE_ID,SERVICE_NAME]
     */
    public static function getServicesList()
    {
        return ArrayHelper::map(Service::find()->all(), 'SERVICE_ID', 'SERVICE_NAME');
    }
    
    /**
     * Return an array of all enabled services
     * @return array[SERVICE_ID,SERVICE_NAME]
     */
    public static function getAllServices(){
        return ArrayHelper::map(Service::findAll(['SERVICE_ISENABLE' => 1]), 'SERVICE_ID', 'SERVICE_ID');
    }
    
    /**
     * Return all accessible Services for a user
     * @param type $userId
     * @return array[SERVICE]
     */
    public static function getServicesByUser($userId){
        $gpaSQLCommand = Service::find()
                ->select(Service::tableName().".*")
                ->innerJoin(GroupAccessService::tableName()." gas", Service::tableName().".SERVICE_ID=gas.SERVICE_SERVICE_ID")
                ->innerJoin(Group::tableName()." g", "g.GROUP_ID=gas.GROUP_GROUP_ID")
                ->innerJoin(Belong::tableName()." b", "b.GROUP_GROUP_ID=g.GROUP_ID")
                ->where(['b.USER_USER_ID' => $userId])
                ->createCommand()->rawSql;
        
        $pasSQLCommand = Service::find()
                ->select(Service::tableName().".*")
                ->innerJoin(PositionAccessService::tableName()." pas", Service::tableName().".SERVICE_ID=pas.SERVICE_SERVICE_ID")
                ->innerJoin(Position::tableName()." p", "p.POSITION_ID=pas.POSITION_POSITION_ID")
                ->innerJoin(Work::tableName()." w", "w.POSITION_POSITION_ID=p.POSITION_ID")
                ->where([
                    'w.USER_USER_ID' => $userId,
                    'p.POSITION_ISDELETED' => false,
                    'w.WORK_TO' => null
                        ])
                ->union($gpaSQLCommand)
                ->all();
        
        return $pasSQLCommand;        
    }
}
