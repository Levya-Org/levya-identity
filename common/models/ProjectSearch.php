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
 * ProjectSearch represents the model behind the search form about `common\models\Project`.
 */
class ProjectSearch extends Project
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PROJECT_ID', 'PROJECT_ISACTIVE', 'PROJECT_ISDELETED', 'PROJECT_ISOPEN', 'PROJECT_PRIORITY'], 'integer'],
            [['PROJECT_NAME', 'PROJECT_DESCRIPTION', 'PROJECT_WEBSITE', 'PROJECT_LOGO', 'PROJECT_CREATIONDATE', 'PROJECT_UPDATEDATE'], 'safe'],
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
        $query = Project::find();

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
            'PROJECT_ID' => $this->PROJECT_ID,
            'PROJECT_CREATIONDATE' => $this->PROJECT_CREATIONDATE,
            'PROJECT_UPDATEDATE' => $this->PROJECT_UPDATEDATE,
            'PROJECT_ISACTIVE' => $this->PROJECT_ISACTIVE,
            'PROJECT_ISDELETED' => $this->PROJECT_ISDELETED,
            'PROJECT_ISOPEN' => $this->PROJECT_ISOPEN,
            'PROJECT_PRIORITY' => $this->PROJECT_PRIORITY,
        ]);

        $query->andFilterWhere(['like', 'PROJECT_NAME', $this->PROJECT_NAME])
            ->andFilterWhere(['like', 'PROJECT_DESCRIPTION', $this->PROJECT_DESCRIPTION])
            ->andFilterWhere(['like', 'PROJECT_WEBSITE', $this->PROJECT_WEBSITE])
            ->andFilterWhere(['like', 'PROJECT_LOGO', $this->PROJECT_LOGO]);

        return $dataProvider;
    }
}
