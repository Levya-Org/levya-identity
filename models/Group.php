<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "GROUP".
 *
 * @property integer $GROUP_ID
 * @property string $GROUP_NAME
 * @property string $GROUP_LDAPNAME 
 * @property integer $GROUP_ISENABLE
 * @property integer $GROUP_ISDEFAULT
 *
 * @property BELONG[] $bELONGS
 * @property SERVICE[] $sERVICES
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'GROUP';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GROUP_NAME', 'GROUP_LDAPNAME', 'GROUP_ISENABLE', 'GROUP_ISDEFAULT'], 'required'],
            [['GROUP_ISENABLE', 'GROUP_ISDEFAULT'], 'boolean'],
            [['GROUP_NAME'], 'string', 'max' => 225],
            [['GROUP_LDAPNAME'], 'string', 'max' => 45],
            
            [['GROUP_NAME', 'GROUP_LDAPNAME'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GROUP_ID' => Yii::t('app/group', 'Group  ID'),
            'GROUP_NAME' => Yii::t('app/group', 'Group  Name'),
            'GROUP_LDAPNAME'=> Yii::t('app/group', 'Group LDAP Name'),
            'GROUP_ISENABLE' => Yii::t('app/group', 'Group  Isenable'),
            'GROUP_ISDEFAULT' => Yii::t('app/group', 'Group  Isdefault'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBELONGS()
    {
        return $this->hasMany(BELONG::className(), ['GROUP_GROUP_ID' => 'GROUP_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSERVICES()
    {
        return $this->hasMany(Service::className(), ['SERVICE_ID' => 'SERVICE_SERVICE_ID'])
                ->viaTable(GroupAccessService::tableName(), ['GROUP_GROUP_ID' => 'GROUP_ID']);
    }
}
