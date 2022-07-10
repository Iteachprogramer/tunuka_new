<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Outcome;

/**
 * OutcomeSearch represents the model behind the search form about `common\models\Outcome`.
 */
class OutcomeSearch extends Outcome
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'product_type_id', 'unit_id','type_id','group_id'], 'integer'],
            [['size', 'count', 'total_size', 'total', 'discount','cost'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
        if ($query==null){
            $query = Outcome::find()->with(['client','productType','unity']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 200,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);
        $this->load($params);
        if (!empty($this->created_at)) {
            $dates = explode(' - ', $this->created_at, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'outcome.created_at', $begin])
                    ->andFilterWhere(['<', 'outcome.created_at', $end]);
            }

        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'product_type_id' => $this->product_type_id,
            'size' => $this->size,
            'count' => $this->count,
            'total_size' => $this->total_size,
            'total' => $this->total,
            'unit_id' => $this->unit_id,
            'discount' => $this->discount,
            'cost' => $this->cost,
            'type_id'=>$this->type_id,
            'group_id'=>$this->group_id,
        ]);
        return $dataProvider;
    }
}
