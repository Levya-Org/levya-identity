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
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "USERSTATE".
 *
 * @property integer $USERSTATE_ID
 * @property string $USERSTATE_NAME
 * @property string $USERSTATE_DESCRIPTION
 * @property integer $USERSTATE_DEFAULT
 *
 * @property USER[] $uSERs
 */
class UserState extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'USERSTATE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USERSTATE_NAME', 'USERSTATE_DESCRIPTION', 'USERSTATE_DEFAULT'], 'required'],
            [['USERSTATE_DESCRIPTION'], 'string'],
            [['USERSTATE_DEFAULT'], 'integer'],
            [['USERSTATE_NAME'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'USERSTATE_ID' => Yii::t('app/user', 'Userstate  ID'),
            'USERSTATE_NAME' => Yii::t('app/user', 'Userstate  Name'),
            'USERSTATE_DESCRIPTION' => Yii::t('app/user', 'Userstate  Description'),
            'USERSTATE_DEFAULT' => Yii::t('app/user', 'Userstate  Default'),
        ];
    }
    
    /**
     * Return an array of all UserState
     * @return array[USERSTATE_ID,USERSTATE_NAME]
     */
    public static function getUserStatesList()
    {
        return ArrayHelper::map(UserState::find()->all(), 'USERSTATE_ID', 'USERSTATE_NAME');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUSERs()
    {
        return $this->hasMany(User::className(), ['USERSTATE_USERSTATE_ID' => 'USERSTATE_ID']);
    }
}
