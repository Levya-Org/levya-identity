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

/**
 * This is the model class for table "PARAM".
 *
 * @property integer $PARAM_ID
 * @property string $PARAM_NAME
 * @property string $PARAM_VALUE
 * @property string $PARAM_TYPE
 */
class Param extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PARAM';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PARAM_NAME', 'PARAM_VALUE'], 'required'],
            [['PARAM_NAME'], 'string', 'max' => 255],
            [['PARAM_VALUE'], 'string', 'max' => 45],
            [['PARAM_TYPE'], 'string', 'max' => 20],
            [['PARAM_NAME'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PARAM_ID' => Yii::t('app/param', 'Param  ID'),
            'PARAM_NAME' => Yii::t('app/param', 'Param  Name'),
            'PARAM_VALUE' => Yii::t('app/param', 'Param  Value'),
            'PARAM_TYPE' => Yii::t('app/param', 'Param  Type'),
        ];
    }
    
    /**
     * Return a Param model from his name
     * @param string $paramName
     * @return app\model\Param
     */
    public static function getParam($paramName){
        \Yii::getLogger()->log('getParam', Logger::LEVEL_TRACE);
        
        return Param::findOne([
            'PARAM_NAME' => $paramName,
        ]);
    }
    
    /**
     * Return a Param value from his name
     * If not found in DB, searched in param.php
     * @param string $paramName
     * @return paral value
     */
    public static function  getParamValue($paramName){
        \Yii::getLogger()->log('getParamValue', Logger::LEVEL_TRACE);
        $model = Param::getParam($paramName);
        if(isset($model)) {
            return $model->PARAM_VALUE;
        }            
        else if(array_key_exists($paramName,\Yii::$app->params)) {
            \Yii::getLogger()->log('Accessing a non existing Param in DB : '.$paramName, Logger::LEVEL_WARNING);   
            return \Yii::$app->params[$paramName];
        }
        else {
            \Yii::getLogger()->log('Searching a non existing Param : '.$paramName, Logger::LEVEL_ERROR);
            return false;
        }
    }
}
