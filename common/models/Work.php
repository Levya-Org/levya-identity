<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "WORK".
 *
 * @property string $BELONG_ID
 * @property string $BELONG_FROM
 * @property string $BELONG_TO
 * @property integer $BELONG_ISACCEPTED
 * @property integer $BELONG_ISLOCKED
 * @property string $USER_USER_ID
 * @property integer $PROJECT_PROJECT_ID
 * @property integer $POSITION_POSITION_ID
 *
 * @property USER $uSERUSER
 * @property POSITION $pOSITIONPOSITION
 * @property PROJECT $pROJECTPROJECT
 */
class Work extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'WORK';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['BELONG_FROM', 'BELONG_TO'], 'safe'],
            [['BELONG_ISACCEPTED', 'BELONG_ISLOCKED', 'USER_USER_ID', 'PROJECT_PROJECT_ID', 'POSITION_POSITION_ID'], 'integer'],
            [['USER_USER_ID', 'PROJECT_PROJECT_ID', 'POSITION_POSITION_ID'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BELONG_ID' => Yii::t('app/project', 'Belong  ID'),
            'BELONG_FROM' => Yii::t('app/project', 'Belong  From'),
            'BELONG_TO' => Yii::t('app/project', 'Belong  To'),
            'BELONG_ISACCEPTED' => Yii::t('app/project', 'Belong  Isaccepted'),
            'BELONG_ISLOCKED' => Yii::t('app/project', 'Belong  Islocked'),
            'USER_USER_ID' => Yii::t('app/project', 'User  User  ID'),
            'PROJECT_PROJECT_ID' => Yii::t('app/project', 'Project  Project  ID'),
            'POSITION_POSITION_ID' => Yii::t('app/project', 'Position  Position  ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUSERUSER()
    {
        return $this->hasOne(USER::className(), ['USER_ID' => 'USER_USER_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPOSITIONPOSITION()
    {
        return $this->hasOne(POSITION::className(), ['POSITION_ID' => 'POSITION_POSITION_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPROJECTPROJECT()
    {
        return $this->hasOne(PROJECT::className(), ['PROJECT_ID' => 'PROJECT_PROJECT_ID']);
    }
}
