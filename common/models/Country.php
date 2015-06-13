<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "COUNTRY".
 *
 * @property integer $COUNTRY_ID
 * @property string $COUNTRY_CODE
 * @property string $COUNTRY_NAME
 * @property string $COUNTRY_CONTINENT
 * @property USER[] $r_Users
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'COUNTRY';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['COUNTRY_CODE', 'COUNTRY_NAME'], 'required'],
            [['COUNTRY_CODE', 'COUNTRY_CONTINENT'], 'string', 'max' => 2],
            [['COUNTRY_NAME'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'COUNTRY_ID' => Yii::t('app/geodata', 'Country ID'),
            'COUNTRY_CODE' => Yii::t('app/geodata', 'Country Code'),
            'COUNTRY_NAME' => Yii::t('app/geodata', 'Country Name'),
            'COUNTRY_CONTINENT' => Yii::t('app/geodata', 'Country Continent'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getr_Users()
    {
        return $this->hasMany(USER::className(), ['COUNTRY_COUNTRY_ID' => 'COUNTRY_ID']);
    }
    
    /**
     * Return an array of all countries
     * @return array[COUNTRY_ID,Country]
     */
    public static function getCountriesList()
    {
        return ArrayHelper::map(Country::find()->all(), 'COUNTRY_ID', 'COUNTRY_NAME');
    }
    
    /**
     * Get all Country like 
     * @param type $term
     * @return type
     */
    public static function getCountryLike($term) {
        return Country::find()
                ->select([
                    'COUNTRY_ID',
                    'COUNTRY_NAME'
                ])
                ->andFilterWhere(['like', 'COUNTRY_NAME', $term])
                ->all();
    }
}
