<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MakeProductItem;

/**
 * MakeProductItemSearch represents the model behind the search form about `common\models\MakeProductItem`.
 */
class MakeProductItemSearch extends MakeProductItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id',], 'integer'],
            [['outcome_size', 'residue_size'], 'number'],
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
    public function search($params,$query=null)
    {
        if ($query===null){
            $query = MakeProductItem::find();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'income_id' => $this->income_id,
            'make_id' => $this->make_id,
            'outcome_size' => $this->outcome_size,
            'residue_size' => $this->residue_size,
        ]);

        return $dataProvider;
    }
}
