<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Param;

/**
 * ParamSearch represents the model behind the search form about `app\models\Param`.
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
