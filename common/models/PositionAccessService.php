<?php

namespace common\models;

use Yii;

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
            [['SERVICE_SERVICE_ID', 'POSITION_POSITION_ID'], 'integer']
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
}
