<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OutcomeGroup;

/**
 * OutcomeGroupSearch represents the model behind the search form about `common\models\OutcomeGroup`.
 */
class OutcomeGroupSearch extends OutcomeGroup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'status', 'discount', 'total','order_number'], 'integer'],
            [['date', 'created_by', 'updated_by'], 'safe'],
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
    public function search($params, $query = null)
    {
        if ($query === null) {
            $query = OutcomeGroup::find()
                ->with(['client'])
                ->joinWith('createdBy');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                'pageSize' => 50,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);
        if (!empty($this->date)) {
            $dates = explode(' - ', $this->date, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'outcome_group.date', $begin])
                    ->andFilterWhere(['<', 'outcome_group.date', $end]);
            }

        }
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'status' => $this->status,
            'discount' => $this->discount,
            'total' => $this->total,
            'order_number' => $this->order_number,
        ]);
        $query
            ->andFilterWhere(['like', 'user.firstname', $this->created_by])
        ;
        return $dataProvider;
    }
}
