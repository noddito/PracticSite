<?php

declare(strict_types=1);

namespace common\models\search;

use common\models\UserOrder;
use yii\data\ActiveDataProvider;

/**
 * UserOrderSearch represents the model behind the search form of `common\models\UserOrder`.
 */
class UserOrderSearch extends UserOrder
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['order_id', 'user_id'], 'integer'],
            [['description'], 'safe'],
            [['total_price'], 'number'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = UserOrder::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
        ]);
        $query->andFilterWhere(['like', 'description', $this->description])->with(['user', 'status']);

        return $dataProvider;
    }
}
