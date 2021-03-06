<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Account;

/**
 * AccountSearch represents the model behind the search form of `common\models\Account`.
 */
class AccountSearch extends Account
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'type_id', 'sum', 'dollar', 'bank', 'total', 'expense_type_id', 'is_main', 'created_at', 'updated_at', 'created_by', 'updated_by','employee_id','order_number'], 'integer'],
            [['dollar_course'], 'number'],
            [['comment', 'date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params = null,$query=null)
    {
        if ($query==null) {
            $query = Account::find()->with('expenseType');
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
        if (!empty($this->date)) {
            $dates = explode(' - ', $this->date, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'account.date', $begin])
                    ->andFilterWhere(['<', 'account.date', $end]);
            }
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'type_id' => $this->type_id,
            'sum' => $this->sum,
            'dollar' => $this->dollar,
            'dollar_course' => $this->dollar_course,
            'bank' => $this->bank,
            'total' => $this->total,
            'expense_type_id' => $this->expense_type_id,
            'employee_id' => $this->employee_id,
            'is_main' => $this->is_main,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'order_number' => $this->order_number,
        ]);
        $query->andFilterWhere(['like', 'comment', $this->comment]);
        return $dataProvider;
    }
}
