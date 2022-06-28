<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductList;

/**
 * ProductListSearch represents the model behind the search form about `common\models\ProductList`.
 */
class ProductListSearch extends ProductList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type_id','sort_order', 'size_type_id', 'created_at', 'updated_at','surface_type', 'created_by', 'updated_by', 'status'], 'integer'],
            [['residue', 'selling_price_uz', 'selling_price_usd', 'selling_rentail'], 'number'],
            [['product_name'],'safe'],
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
        $query = ProductList::find()->with('sizeType');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'type_id' => $this->type_id,
            'residue' => $this->residue,
            'sort_order' => $this->sort_order,
            'size_type_id' => $this->size_type_id,
            'selling_price_uz' => $this->selling_price_uz,
            'selling_price_usd' => $this->selling_price_usd,
            'selling_rentail' => $this->selling_rentail,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
            'surface_type' => $this->surface_type,
        ]);
        $query->andFilterWhere(['like', 'product_name', $this->product_name]);
        return $dataProvider;
    }
}
