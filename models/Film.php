<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Модель фильма
 *
 * @property int $id ID
 * @property string $title Название фильма
 * @property string|null $photo_ext Расширение файла постера
 * @property string|null $description Описание фильма
 * @property int $duration Продолжительность в минутах
 * @property string $age_restriction Возрастные ограничения
 * @property string $created_at Дата создания
 * @property string $updated_at Дата обновления
 *
 * @property Session[] $sessions Сеансы фильма
 * @property UploadedFile $imageFile Файл постера
 */
class Film extends ActiveRecord
{
    /**
     * @var UploadedFile Файл постера для загрузки
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'film';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'duration', 'age_restriction'], 'required'],
            [['description'], 'string'],
            [['duration'], 'integer', 'min' => 1],
            [['title'], 'string', 'max' => 255],
            [['age_restriction'], 'string', 'max' => 10],
            [
                ['imageFile'],
                'file',
                'skipOnEmpty' => false,
                'on' => 'create',
                'extensions' => 'png, jpg, jpeg',
                'maxSize' => 2 * 1024 * 1024
            ],
            [
                ['imageFile'],
                'file',
                'skipOnEmpty' => true,
                'on' => 'update',
                'extensions' => 'png, jpg, jpeg',
                'maxSize' => 2 * 1024 * 1024
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название фильма',
            'photo_ext' => 'Расширение фото',
            'imageFile' => 'Постер фильма',
            'description' => 'Описание',
            'duration' => 'Продолжительность (мин)',
            'age_restriction' => 'Возрастные ограничения',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Получает сеансы фильма
     *
     * @return ActiveQuery Запрос для получения сеансов
     */
    public function getSessions(): ActiveQuery
    {
        return $this->hasMany(Session::class, ['film_id' => 'id']);
    }

    /**
     * {@inheritDoc}
     */
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->imageFile) {
            $uploadPath = Yii::getAlias('@uploads/films/');
            $fileName = $this->id . '.' . $this->imageFile->extension;
            $filePath = $uploadPath . $fileName;

            if ($this->imageFile->saveAs($filePath)) {
                $this->updateAttributes(['photo_ext' => $this->imageFile->extension]);
            }
        }
    }

    /**
     * Получает URL постера фильма
     *
     * @return string|null URL постера или null если постер отсутствует
     */
    public function getImageUrl(): ?string
    {
        if (empty($this->photo_ext)) {
            return null;
        }

        $filePath = Yii::getAlias('@uploads/films/') . $this->id . '.' . $this->photo_ext;

        if (!file_exists($filePath)) {
            Yii::warning("Image file not found: {$filePath}", __METHOD__);
            return null;
        }

        return Yii::getAlias('@uploadsUrl/films/') . $this->id . '.' . $this->photo_ext;
    }

    /**
     * Удаляет файл постера при удалении фильма
     */
    public function afterDelete(): void
    {
        parent::afterDelete();

        if (!empty($this->photo_ext)) {
            $filePath = Yii::getAlias('@uploads/films/') . $this->id . '.' . $this->photo_ext;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}