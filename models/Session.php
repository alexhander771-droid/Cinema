<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $film_id
 * @property string $start_at
 * @property string $price
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Film $film
 */
class Session extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['film_id', 'start_at', 'price'], 'required'],
            [['film_id'], 'integer'],
            [['start_at'], 'safe'],
            [['price'], 'number'],
            [['film_id'], 'exist', 'skipOnError' => true, 'targetClass' => Film::className(), 'targetAttribute' => ['film_id' => 'id']],
            ['start_at', 'validateSessionTime'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'film_id' => 'Фильм',
            'start_at' => 'Дата и время начала',
            'price' => 'Стоимость',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilm()
    {
        return $this->hasOne(Film::className(), ['id' => 'film_id']);
    }


    /**
     * //TODO: исправить условие на проверку 30 минут
     * @param string $attribute
     * @param array $params
     * @return void
     */
    /**
     * Проверяет, что между сеансами есть интервал не менее 30 минут
     * @param string $attribute
     * @param array $params
     * @return void
     */
    public function validateSessionTime($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $startTime = strtotime($this->start_at);
            $endTime = $startTime + ($this->film->duration * 60);
            $endTimeWithInterval = $endTime + (30 * 60);
            $startTimeWithInterval = $startTime - (30 * 60);

            $conflictingSessions = Session::find()
                ->where([
                    'or',
                    [
                        'and',
                        ['<=', 'start_at', date('Y-m-d H:i:s', $endTimeWithInterval)],
                        ['>=', "DATE_ADD(start_at, INTERVAL (SELECT duration FROM film WHERE film.id = session.film_id) MINUTE)", date('Y-m-d H:i:s', $startTime)]
                    ],
                    [
                        'and',
                        ['<=', 'start_at', date('Y-m-d H:i:s', $endTime)],
                        ['>=', "DATE_ADD(start_at, INTERVAL (SELECT duration FROM film WHERE film.id = session.film_id) MINUTE)", date('Y-m-d H:i:s', $startTimeWithInterval)]
                    ]
                ])
                ->andWhere(['not', ['id' => $this->id]])
                ->exists();

            if ($conflictingSessions) {
                $this->addError($attribute, 'Между сеансами должно быть не менее 30 минут свободного времени.');
            }
        }
    }


    /**
     * @param Session $model
     * @return bool
     */
    protected function loadAndSaveModel($model)
    {
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return true;
        }
        return false;
    }

    public function getEndTime()
    {
        if ($this->start_at && $this->film) {
            $start = new \DateTime($this->start_at);
            $start->modify('+' . $this->film->duration . ' minutes');
            return $start->format('Y-m-d H:i:s');
        }
        return null;
    }
}
