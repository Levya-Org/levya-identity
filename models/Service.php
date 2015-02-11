<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SERVICE".
 *
 * @property integer $SERVICE_ID
 * @property string $SERVICE_LDAPNAME
 * @property string $SERVICE_NAME
 * @property string $SERVICE_DESCRIPTION
 * @property integer $SERVICE_ISENABLE
 * @property integer $SERVICE_STATE
 *
 * @property GROUPACCESSSERVICE[] $gROUPACCESSSERVICEs
 * @property POSITIONACCESSSERVICE[] $pOSITIONACCESSSERVICEs
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
            [['SERVICE_LDAPNAME', 'SERVICE_NAME', 'SERVICE_DESCRIPTION', 'SERVICE_ISENABLE', 'SERVICE_STATE'], 'required'],
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
            'SERVICE_DESCRIPTION' => Yii::t('app/service', 'Service  Description'),
            'SERVICE_ISENABLE' => Yii::t('app/service', 'Service  Isenable'),
            'SERVICE_STATE' => Yii::t('app/service', 'Service  State'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPOSITIONACCESSSERVICES()
    {
        return $this->hasMany(POSITIONACCESSSERVICE::className(), ['SERVICE_SERVICE_ID' => 'SERVICE_ID']);
    }
}
