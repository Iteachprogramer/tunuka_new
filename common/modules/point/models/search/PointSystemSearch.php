<?php

namespace common\modules\point\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\point\models\PointSystem;

/**
 * PointSystemSearch represents the model behind the search form about `common\modules\point\models\PointSystem`.
 */
class PointSystemSearch extends PointSystem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id'], 'integer'],
            [['point'], 'number'],
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
        $query = PointSystem::find()->with('client');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'point' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'point' => $this->point,
        ]);

        return $dataProvider;
    }
}
