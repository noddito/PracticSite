<?php

declare(strict_types=1);

namespace common\models\search;

use common\models\Product;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 * @property mixed|null $updated_at
 * @property mixed|null $created_at
 */
class ProductSearch extends Product
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name', 'description'], 'safe'],
            [['created_at', 'updated_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['created_at', 'updated_at'], 'default', 'value' => null],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Product::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        if ($this->created_at !== null) {
            $query->andFilterWhere(['between', 'created_at', $this->created_at, $this->created_at + 3600 * 24]);
        }
        if ($this->updated_at !== null) {
            $query->andFilterWhere(['between', 'updated_at', $this->updated_at, $this->updated_at + 3600 * 24]);
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->with(['category', 'tags']);

        return $dataProvider;
    }
}
