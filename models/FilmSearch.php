<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Film;


class FilmSearch extends Film
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['id', 'duration'], 'integer'],
      [['title', 'photo_ext', 'description', 'age_restriction', 'created_at', 'updated_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function scenarios()
  {
    return Model::scenarios();
  }

  /**
   *
   * @param array 
   * @param string|null 
   * @return ActiveDataProvider
   */
  public function search($params, $formName = null)
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
