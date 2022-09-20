<?php

declare(strict_types=1);

namespace common\models\search;

use common\models\Status;
use yii\data\ActiveDataProvider;

/**
 * StatusSearch represents the model behind the search form of `common\models\Status`.
 */
class StatusSearch extends Status
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['status'], 'safe'],
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
        $query = Status::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
