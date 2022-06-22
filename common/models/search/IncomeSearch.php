<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Income;

/**
 * IncomeSearch represents the model behind the search form about `common\models\Income`.
 */
class IncomeSearch extends Income
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_type_id', 'provider_id', 'unity_type_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['cost', 'weight', 'length', 'cost_of_living', 'dollar_course', 'total', 'price_per_meter','date'], 'number'],
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
            $query = Income::find();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);
        if (!empty($this->date)) {
            $dates = explode(' - ', $this->date, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'income.date', $begin])
                    ->andFilterWhere(['<', 'income.date', $end]);
            }

        }
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'product_type_id' => $this->product_type_id,
            'cost' => $this->cost,
            'provider_id' => $this->provider_id,
            'weight' => $this->weight,
            'length' => $this->length,
            'cost_of_living' => $this->cost_of_living,
            'dollar_course' => $this->dollar_course,
            'total' => $this->total,
            'price_per_meter' => $this->price_per_meter,
            'unity_type_id' => $this->unity_type_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'date' => $this->date,
        ]);

        return $dataProvider;
    }
}
