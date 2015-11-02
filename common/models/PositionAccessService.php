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
use yii\log\Logger;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "POSITION_ACCESS_SERVICE".
 *
 * @property integer $SERVICE_SERVICE_ID
 * @property integer $POSITION_POSITION_ID
 *
 * @property SERVICE $sERVICESERVICE
 * @property POSITION $pOSITIONPOSITION
 */
class PositionAccessService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'POSITION_ACCESS_SERVICE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SERVICE_SERVICE_ID', 'POSITION_POSITION_ID'], 'required'],
            [['SERVICE_SERVICE_ID', 'POSITION_POSITION_ID'], 'integer'],
            ['SERVICE_SERVICE_ID', 'exist', 'targetClass' => 'common\models\SERVICE', 'targetAttribute' => 'SERVICE_ID'],
            ['POSITION_POSITION_ID', 'exist', 'targetClass' => 'common\models\POSITION', 'targetAttribute' => 'POSITION_ID'],
            [['SERVICE_SERVICE_ID', 'POSITION_POSITION_ID'], 'unique', 'targetAttribute' => ['SERVICE_SERVICE_ID', 'POSITION_POSITION_ID']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SERVICE_SERVICE_ID' => Yii::t('app/position', 'Service  Service  ID'),
            'POSITION_POSITION_ID' => Yii::t('app/position', 'Position  Position  ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSERVICESERVICE()
    {
        return $this->hasOne(SERVICE::className(), ['SERVICE_ID' => 'SERVICE_SERVICE_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPOSITIONPOSITION()
    {
        return $this->hasOne(POSITION::className(), ['POSITION_ID' => 'POSITION_POSITION_ID']);
    }
    
    /**
     * Create a PAS
     * @return boolean
     * @throws \RuntimeException
     * @throws \common\models\Exception
     * @throws \ErrorException
     */
    public function create(){
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing PAS');
        }
        
        $transaction = $this->getDb()->beginTransaction();
        
        try {            
            if ($this->save()) {
                \Yii::getLogger()->log('PAS has been created', Logger::LEVEL_INFO);
                $transaction->commit();
                return true;
            }
            else {
                \Yii::getLogger()->log('PAS hasn\'t been created'.VarDumper::dumpAsString($this->errors), Logger::LEVEL_WARNING);
                throw  new \ErrorException('PAS error at creation, see Model error.');
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            \Yii::getLogger()->log('An error occurred while creating a PAS'.VarDumper::dumpAsString($ex), Logger::LEVEL_ERROR);
            throw $ex;
        }
        return false;
    }
}
