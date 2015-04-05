<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "COUNTRY".
 *
 * @property integer $CountryId
 * @property string $Country
 * @property string $FIPS104
 * @property string $ISO2
 * @property string $ISO3
 * @property string $ISON
 * @property string $Internet
 * @property string $Capital
 * @property string $MapReference
 * @property string $NationalitySingular
 * @property string $NationalityPlural
 * @property string $Currency
 * @property string $CurrencyCode
 * @property string $Population
 * @property string $Title
 * @property string $Comment
 *
 * @property City[] $cITies
 * @property REGION[] $rEGIONs
 * @property USER[] $uSERs
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
            [['Country', 'FIPS104', 'ISO2', 'ISO3', 'ISON', 'Internet'], 'required'],
            [['Population'], 'integer'],
            [['Country', 'MapReference', 'Title'], 'string', 'max' => 50],
            [['FIPS104', 'ISO2', 'Internet'], 'string', 'max' => 2],
            [['ISO3', 'CurrencyCode'], 'string', 'max' => 3],
            [['ISON'], 'string', 'max' => 4],
            [['Capital'], 'string', 'max' => 25],
            [['NationalitySingular', 'NationalityPlural'], 'string', 'max' => 35],
            [['Currency'], 'string', 'max' => 30],
            [['Comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CountryId' => Yii::t('app/geodata', 'Country ID'),
            'Country' => Yii::t('app/geodata', 'Country'),
            'FIPS104' => Yii::t('app/geodata', 'Fips104'),
            'ISO2' => Yii::t('app/geodata', 'Iso2'),
            'ISO3' => Yii::t('app/geodata', 'Iso3'),
            'ISON' => Yii::t('app/geodata', 'Ison'),
            'Internet' => Yii::t('app/geodata', 'Internet'),
            'Capital' => Yii::t('app/geodata', 'Capital'),
            'MapReference' => Yii::t('app/geodata', 'Map Reference'),
            'NationalitySingular' => Yii::t('app/geodata', 'Nationality Singular'),
            'NationalityPlural' => Yii::t('app/geodata', 'Nationality Plural'),
            'Currency' => Yii::t('app/geodata', 'Currency'),
            'CurrencyCode' => Yii::t('app/geodata', 'Currency Code'),
            'Population' => Yii::t('app/geodata', 'Population'),
            'Title' => Yii::t('app/geodata', 'Title'),
            'Comment' => Yii::t('app/geodata', 'Comment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCITies()
    {
        return $this->hasMany(City::className(), ['CountryID' => 'CountryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getREGIONs()
    {
        return $this->hasMany(REGION::className(), ['CountryID' => 'CountryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUSERs()
    {
        return $this->hasMany(USER::className(), ['COUNTRY_CountryId' => 'CountryId']);
    }
    
    /**
     * Return an array of all countries
     * @return array[CountryId,Country]
     */
    public static function getCountriesList()
    {
        return ArrayHelper::map(Country::find()->all(), 'CountryId', 'Country');
    }
    
    /**
     * Get all Country like 
     * @param type $term
     * @return type
     */
    public function getCountryLike($term) {
        return Country::find()
                ->select([
                    'CountryId',
                    'Country'
                ])
                ->andFilterWhere(['like', 'Country', $term])
                ->all();
    }
}
