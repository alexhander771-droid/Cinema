<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * @property int $id
 * * @property int $film_id
 * * @property string $start_time
 * * @property string $end_time
 * * @property int $hall_id
 * * @property float $price
 * * @property string $created_at
 * * @property string $updated_at
 * *
 * * @property Film $film
 * * @property Hall $hall
 * */
class Film extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'film';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'duration', 'age_restriction'], 'required'],
            [['description'], 'string'],
            [['duration'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['age_restriction'], 'string', 'max' => 10],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'on' => 'create', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 2 * 1024 * 1024],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'on' => 'update', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 2 * 1024 * 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название фильма',
            'photo_ext' => 'Расширение фото',
            'imageFile' => 'Постер фильма',
            'description' => 'Описание',
            'duration' => 'Продолжительность (мин)',
            'age_restriction' => 'Возрастные ограничения',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessions()
    {
        return $this->hasMany(Session::className(), ['film_id' => 'id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->imageFile) {
            $uploadPath = Yii::getAlias('@uploads/films/');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $fileName = $this->id . '.' . $this->imageFile->extension;
            $filePath = $uploadPath . $fileName;
            $this->imageFile->saveAs($filePath);
            $this->updateAttributes(['photo_ext' => $this->imageFile->extension]);
        }
    }

    public function getImageUrl()
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
}
