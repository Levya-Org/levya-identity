<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * GroupSearch represents the model behind the search form about `common\models\Group`.
 */
class GroupSearch extends Group
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GROUP_ID', 'GROUP_ISENABLE', 'GROUP_ISDEFAULT'], 'integer'],
            [['GROUP_NAME'], 'safe'],
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
        $query = Group::find();

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
            'GROUP_ID' => $this->GROUP_ID,
            'GROUP_ISENABLE' => $this->GROUP_ISENABLE,
            'GROUP_ISDEFAULT' => $this->GROUP_ISDEFAULT,
        ]);

        $query->andFilterWhere(['like', 'GROUP_NAME', $this->GROUP_NAME]);

        return $dataProvider;
    }
}
