<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ServiceSearch represents the model behind the search form about `common\models\Service`.
 */
class ServiceSearch extends Service
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SERVICE_ID', 'SERVICE_ISENABLE', 'SERVICE_STATE'], 'integer'],
            [['SERVICE_LDAPNAME', 'SERVICE_NAME', 'SERVICE_DESCRIPTION'], 'safe'],
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
        $query = Service::find();

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
            'SERVICE_ID' => $this->SERVICE_ID,
            'SERVICE_ISENABLE' => $this->SERVICE_ISENABLE,
            'SERVICE_STATE' => $this->SERVICE_STATE,
        ]);

        $query->andFilterWhere(['like', 'SERVICE_LDAPNAME', $this->SERVICE_LDAPNAME])
            ->andFilterWhere(['like', 'SERVICE_NAME', $this->SERVICE_NAME])
            ->andFilterWhere(['like', 'SERVICE_DESCRIPTION', $this->SERVICE_DESCRIPTION]);

        return $dataProvider;
    }
}
