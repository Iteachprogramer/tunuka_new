<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Employees;

/**
 * EmployeesSearch represents the model behind the search form about `common\models\Employees`.
 */
class EmployeesSearch extends Employees
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'salary', 'is_factory', 'status', ], 'integer'],
            [['name', 'created_by', 'updated_by'], 'safe'],
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
        $query = Employees::find()->joinWith('createdBy');

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
            'salary' => $this->salary,
            'is_factory' => $this->is_factory,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'user.username', $this->created_by])
        ;

        return $dataProvider;
    }
}
