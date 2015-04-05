<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Position;

/**
 * PositionSearch represents the model behind the search form about `common\models\Position`.
 */
class PositionSearch extends Position
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POSITION_ID', 'POSITION_ISOBLIGATORY', 'POSITION_ISDELETED', 'POSITION_NEEDDONATION', 'POSITION_NEEDSUBSCRIPTION', 'PROJECT_PROJECT_ID'], 'integer'],
            [['POSITION_NAME', 'POSITION_DESCRIPTION'], 'safe'],
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
        $query = Position::find();

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
            'POSITION_ID' => $this->POSITION_ID,
            'POSITION_ISOBLIGATORY' => $this->POSITION_ISOBLIGATORY,
            'POSITION_ISDELETED' => $this->POSITION_ISDELETED,
            'POSITION_NEEDDONATION' => $this->POSITION_NEEDDONATION,
            'POSITION_NEEDSUBSCRIPTION' => $this->POSITION_NEEDSUBSCRIPTION,
            'PROJECT_PROJECT_ID' => $this->PROJECT_PROJECT_ID,
        ]);

        $query->andFilterWhere(['like', 'POSITION_NAME', $this->POSITION_NAME])
            ->andFilterWhere(['like', 'POSITION_DESCRIPTION', $this->POSITION_DESCRIPTION]);

        return $dataProvider;
    }
}
