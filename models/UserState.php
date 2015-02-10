<?php

namespace app\models;

use Yii;

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
     * @return \yii\db\ActiveQuery
     */
    public function getUSERs()
    {
        return $this->hasMany(USER::className(), ['USERSTATE_USERSTATE_ID' => 'USERSTATE_ID']);
    }
}
