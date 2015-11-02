<?php
/**
 * This file is part of Levya Identity.
 * 
 * Levya Identity is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Foobar. See file LICENSE(.md) in this source tree, 
 * if not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (C) Levya Team Members
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\Country;

//TODO: transform it to API
class GeodataController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'country' => ['get'],
                    'country-by-id' => ['get']
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'country-by-id'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['country', 'country-by-id'],
                        'roles' => ['administrator', 'developer'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Get all Countries with the $term, in JSON
     * @param type $term
     * @return type
     */
    public function actionCountry($term)
    {
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            $countries = Country::getCountryLike($term);
        
            $to_return = array();

            foreach ($countries as $country) {
                $to_return[] = array(
                    'label' => $country->COUNTRY_NAME,
                    'value' => $country->COUNTRY_NAME,
                    'id' => $country->COUNTRY_ID,
                );
            }
            
            return $to_return; 
        }        
    }
    
    /**
     * Return JSON data for a specific Country ID
     * @param type $id
     * @return string
     */
    public function actionCountryById($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $country = Country::findOne($id);
        if(!$country) 
            return "";
        $to_return[] = array(
            'label' => $country->COUNTRY_NAME,
            'value' => $country->COUNTRY_NAME,
            'id' => $country->COUNTRY_ID,
        );
        
        return $to_return;
    }
}
