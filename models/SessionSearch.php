<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TODO: для красоты файловой структуры можно было переместить в папку models/search
 */
class SessionSearch extends Session
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['id', 'film_id'], 'integer'],
      [['start_at'], 'safe'],
      [['price'], 'number'],
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
   * @param array $params
   *
   * @return ActiveDataProvider
   */
  public function search($params)
  {
    $query = Session::find()->joinWith('film');



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
