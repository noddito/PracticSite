<?php

declare(strict_types=1);

namespace common\models\search;

use common\models\PropertyAttribute;
use yii\data\ActiveDataProvider;

/**
 * PropertyAttributeSearch represents the model behind the search form of `common\models\PropertyAttribute`.
 */
class PropertyAttributeSearch extends PropertyAttribute
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'safe'],
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
        $query = PropertyAttribute::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
