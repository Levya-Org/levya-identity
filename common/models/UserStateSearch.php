<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserStateSearch represents the model behind the search form about `common\models\UserState`.
 */
class UserStateSearch extends UserState
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USERSTATE_ID'], 'integer'],
            [['USERSTATE_NAME', 'USERSTATE_DESCRIPTION'], 'safe'],
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
        $query = UserState::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'USERSTATE_ID' => $this->USERSTATE_ID,
        ]);

        $query->andFilterWhere(['like', 'USERSTATE_NAME', $this->USERSTATE_NAME])
            ->andFilterWhere(['like', 'USERSTATE_DESCRIPTION', $this->USERSTATE_DESCRIPTION]);

        return $dataProvider;
    }
}
