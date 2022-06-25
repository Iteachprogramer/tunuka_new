<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MakeProduct;

/**
 * MakeProductSearch represents the model behind the search form about `common\models\MakeProduct`.
 */
class MakeProductSearch extends MakeProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'employee_id', 'product_id', 'produced_id', 'shape_id', 'type_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['size','factory_size','date'], 'safe'],
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
            $query = MakeProduct::find();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 150,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'product_id' => $this->product_id,
            'produced_id' => $this->produced_id,
            'shape_id' => $this->shape_id,
            'type_id' => $this->type_id,
            'factory_size' => $this->factory_size,
        ]);

        $query->andFilterWhere(['like', 'size', $this->size]);
        if (!empty($this->date)) {
            $dates = explode(' - ', $this->date, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'make_product.date', $begin])
                    ->andFilterWhere(['<', 'make_product.date', $end]);
            }

        }

        return $dataProvider;
    }
}
