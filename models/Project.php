<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PROJECT".
 *
 * @property integer $PROJECT_ID
 * @property string $PROJECT_NAME
 * @property string $PROJECT_DESCRIPTION
 * @property string $PROJECT_WEBSITE
 * @property string $PROJECT_LOGO
 * @property string $PROJECT_CREATIONDATE
 * @property string $PROJECT_UPDATEDATE
 * @property integer $PROJECT_ISACTIVE
 * @property integer $PROJECT_ISDELETED
 * @property integer $PROJECT_ISOPEN
 * @property integer $PROJECT_PRIORITY
 *
 * @property DONATION[] $dONATIONs
 * @property POSITION[] $pOSITIONs
 * @property WORK[] $wORKs
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PROJECT';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PROJECT_NAME', 'PROJECT_DESCRIPTION', 'PROJECT_WEBSITE', 'PROJECT_CREATIONDATE', 'PROJECT_ISACTIVE', 'PROJECT_ISDELETED', 'PROJECT_ISOPEN'], 'required'],
            [['PROJECT_DESCRIPTION'], 'string'],
            [['PROJECT_CREATIONDATE', 'PROJECT_UPDATEDATE'], 'safe'],
            [['PROJECT_ISACTIVE', 'PROJECT_ISDELETED', 'PROJECT_ISOPEN', 'PROJECT_PRIORITY'], 'integer'],
            [['PROJECT_NAME'], 'string', 'max' => 100],
            [['PROJECT_WEBSITE'], 'string', 'max' => 200],
            [['PROJECT_LOGO'], 'string', 'max' => 50],
            [['PROJECT_NAME'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PROJECT_ID' => Yii::t('app/project', 'Project  ID'),
            'PROJECT_NAME' => Yii::t('app/project', 'Project  Name'),
            'PROJECT_DESCRIPTION' => Yii::t('app/project', 'Project  Description'),
            'PROJECT_WEBSITE' => Yii::t('app/project', 'Project  Website'),
            'PROJECT_LOGO' => Yii::t('app/project', 'Project  Logo'),
            'PROJECT_CREATIONDATE' => Yii::t('app/project', 'Project  Creationdate'),
            'PROJECT_UPDATEDATE' => Yii::t('app/project', 'Project  Updatedate'),
            'PROJECT_ISACTIVE' => Yii::t('app/project', 'Project  Isactive'),
            'PROJECT_ISDELETED' => Yii::t('app/project', 'Project  Isdeleted'),
            'PROJECT_ISOPEN' => Yii::t('app/project', 'Project  Isopen'),
            'PROJECT_PRIORITY' => Yii::t('app/project', 'Project  Priority'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDONATIONs()
    {
        return $this->hasMany(DONATION::className(), ['PROJECT_PROJECT_ID' => 'PROJECT_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPOSITIONs()
    {
        return $this->hasMany(POSITION::className(), ['PROJECT_PROJECT_ID' => 'PROJECT_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWORKs()
    {
        return $this->hasMany(WORK::className(), ['PROJECT_PROJECT_ID' => 'PROJECT_ID']);
    }
}
