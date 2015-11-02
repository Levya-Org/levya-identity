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

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ParamSearch represents the model behind the search form about `common\models\Param`.
 */
class ParamSearch extends Param
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PARAM_ID'], 'integer'],
            [['PARAM_NAME', 'PARAM_VALUE', 'PARAM_TYPE'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Param::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'PARAM_ID' => $this->PARAM_ID,
        ]);

        $query->andFilterWhere(['like', 'PARAM_NAME', $this->PARAM_NAME])
            ->andFilterWhere(['like', 'PARAM_VALUE', $this->PARAM_VALUE])
            ->andFilterWhere(['like', 'PARAM_TYPE', $this->PARAM_TYPE]);

        return $dataProvider;
    }
}
