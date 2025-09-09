<?php

namespace app\models;

use DateTime;
use Exception;
use yii\db\ActiveQuery;
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
    public static function tableName(): string
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['film_id', 'start_at', 'price'], 'required', 'message' => 'Поле обязательно для заполнения.'],
            [['film_id'], 'integer', 'message' => 'Значение должно быть целым числом.'],
            [['start_at'], 'safe'],
            [['price'], 'number', 'message' => 'Значение должно быть числом.'],
            [
                ['film_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Film::class,
                'targetAttribute' => ['film_id' => 'id'],
                'message' => 'Указанный фильм не найден.'
            ],
            ['start_at', 'validateSessionTime'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
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
     * @return ActiveQuery
     */
    public function getFilm(): ActiveQuery
    {
        return $this->hasOne(Film::class, ['id' => 'film_id']);
    }

    /**
     * Проверяет, что между сеансами есть интервал не менее 30 минут
     * @param string $attribute
     * @return void
     */
    public function validateSessionTime(string $attribute): void
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
                ->andWhere(['Нет', ['id' => $this->id]])
                ->exists();

            if ($conflictingSessions) {
                $this->addError($attribute, 'Между сеансами должно быть не менее 30 минут свободного времени.');
            }
        }
    }


    /**
     * Вычисление времени окончания
     * @return string|null
     * @throws Exception
     */
    public function getEndTime(): ?string
    {
        if ($this->start_at && $this->film) {
            $start = new DateTime($this->start_at);
            $start->modify('+' . $this->film->duration .' minutes');
            return $start->format('Y-m-d H:i:s');
        }
        return null;
    }
}
