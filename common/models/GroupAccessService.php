<?php

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
            ['SERVICE_SERVICE_ID', 'exist', 'targetClass' => 'common\models\SERVICE', 'targetAttribute' => 'SERVICE_ID'],
            ['GROUP_GROUP_ID', 'exist', 'targetClass' => 'common\models\GROUP', 'targetAttribute' => 'GROUP_ID'],
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
        return $this->hasOne(GROUP::className(), ['GROUP_ID' => 'GROUP_GROUP_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Service()
    {
        return $this->hasOne(SERVICE::className(), ['SERVICE_ID' => 'SERVICE_SERVICE_ID']);
    }
}
