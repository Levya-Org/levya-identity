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

/**
 * This is the model class for table "GROUP_ACCESS_SERVICE".
 *
 * @property integer $GROUP_GROUP_ID
 * @property integer $SERVICE_SERVICE_ID
 *
 * @property GROUP $r_Group
 * @property SERVICE $r_Service
 */
class GroupAccessService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'GROUP_ACCESS_SERVICE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GROUP_GROUP_ID', 'SERVICE_SERVICE_ID'], 'required'],
            [['GROUP_GROUP_ID', 'SERVICE_SERVICE_ID'], 'integer'],
            ['SERVICE_SERVICE_ID', 'exist', 'targetClass' => 'common\models\Service', 'targetAttribute' => 'SERVICE_ID'],
            ['GROUP_GROUP_ID', 'exist', 'targetClass' => 'common\models\Group', 'targetAttribute' => 'GROUP_ID'],
            [['SERVICE_SERVICE_ID', 'GROUP_GROUP_ID'], 'unique', 'targetAttribute' => ['SERVICE_SERVICE_ID', 'GROUP_GROUP_ID']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GROUP_GROUP_ID' => Yii::t('app/group', 'Group  Group  ID'),
            'SERVICE_SERVICE_ID' => Yii::t('app/group', 'Service  Service  ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Group()
    {
        return $this->hasOne(Group::className(), ['GROUP_ID' => 'GROUP_GROUP_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Service()
    {
        return $this->hasOne(Service::className(), ['SERVICE_ID' => 'SERVICE_SERVICE_ID']);
    }
}
