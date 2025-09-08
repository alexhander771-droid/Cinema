<?php

namespace app\models\search;

use app\models\Session;
use yii\data\ActiveDataProvider;

class SessionSearch extends Session
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'film_id'], 'integer'],
            [['start_at'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Session::find()->joinWith('film')
        ->where(['>=', 'start_at', new Expression('NOW()')]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['start_at' => SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }


        $query->andFilterWhere([
            'id' => $this->id,
            'film_id' => $this->film_id,
            'start_at' => $this->start_at,
            'price' => $this->price,
        ]);

        return $dataProvider;
    }
}
