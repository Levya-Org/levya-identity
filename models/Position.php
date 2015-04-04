<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "POSITION".
 *
 * @property integer $POSITION_ID
 * @property string $POSITION_NAME
 * @property string $POSITION_DESCRIPTION
 * @property integer $POSITION_ISOBLIGATORY
 * @property integer $POSITION_ISDELETED
 * @property integer $POSITION_NEEDDONATION
 * @property integer $POSITION_NEEDSUBSCRIPTION
 * @property integer $PROJECT_PROJECT_ID
 *
 * @property PROJECT $pROJECTPROJECT
 * @property POSITIONACCESSSERVICE[] $pOSITIONACCESSSERVICEs
 * @property WORK[] $wORKs
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'POSITION';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POSITION_NAME', 'POSITION_ISOBLIGATORY', 'POSITION_NEEDDONATION', 'POSITION_NEEDSUBSCRIPTION', 'PROJECT_PROJECT_ID'], 'required'],
            [['POSITION_DESCRIPTION'], 'string'],
            [['POSITION_ISOBLIGATORY', 'POSITION_ISDELETED', 'POSITION_NEEDDONATION', 'POSITION_NEEDSUBSCRIPTION', 'PROJECT_PROJECT_ID'], 'integer'],
            [['POSITION_NAME'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POSITION_ID' => Yii::t('app/position', 'Position  ID'),
            'POSITION_NAME' => Yii::t('app/position', 'Position  Name'),
            'POSITION_DESCRIPTION' => Yii::t('app/position', 'Position  Description'),
            'POSITION_ISOBLIGATORY' => Yii::t('app/position', 'Position  Isobligatory'),
            'POSITION_ISDELETED' => Yii::t('app/position', 'Position  Isdeleted'),
            'POSITION_NEEDDONATION' => Yii::t('app/position', 'Position  Needdonation'),
            'POSITION_NEEDSUBSCRIPTION' => Yii::t('app/position', 'Position  Needsubscription'),
            'PROJECT_PROJECT_ID' => Yii::t('app/position', 'Project  Project  ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPROJECTPROJECT()
    {
        return $this->hasOne(PROJECT::className(), ['PROJECT_ID' => 'PROJECT_PROJECT_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPOSITIONACCESSSERVICEs()
    {
        return $this->hasMany(POSITIONACCESSSERVICE::className(), ['POSITION_POSITION_ID' => 'POSITION_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWORKs()
    {
        return $this->hasMany(WORK::className(), ['POSITION_POSITION_ID' => 'POSITION_ID']);
    }
}
