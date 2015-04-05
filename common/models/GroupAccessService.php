<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "GROUP_ACCESS_SERVICE".
 *
 * @property integer $GROUP_GROUP_ID
 * @property integer $SERVICE_SERVICE_ID
 *
 * @property GROUP $GROUP
 * @property SERVICE $SERVICE
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
            [['GROUP_GROUP_ID', 'SERVICE_SERVICE_ID'], 'integer']
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
    public function getGROUP()
    {
        return $this->hasOne(GROUP::className(), ['GROUP_ID' => 'GROUP_GROUP_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSERVICE()
    {
        return $this->hasOne(SERVICE::className(), ['SERVICE_ID' => 'SERVICE_SERVICE_ID']);
    }
}
