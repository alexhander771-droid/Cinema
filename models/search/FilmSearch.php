<?php

namespace app\models\search;

use app\models\Film;
use yii\data\ActiveDataProvider;

class FilmSearch extends Film
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'duration'], 'integer'],
            [['title', 'photo_ext', 'description', 'age_restriction', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @param string|null $formName
     * @return ActiveDataProvider
     */
    public function search(array $params, string $formName = null): ActiveDataProvider
    {
        $query = Film::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'duration' => $this->duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'photo_ext', $this->photo_ext])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'age_restriction', $this->age_restriction]);

        return $dataProvider;
    }
}