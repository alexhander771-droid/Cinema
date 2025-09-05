<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * //TODO а где названия свойств?
 * @property int $id
 * @property string
 * @property string
 * @property string|null
 * @property int
 * @property string
 * @property string
 * @property string
 *
 * @property Session[]
 */
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

    public function beforeSave($insert) // TODO: если нет никакой логики внутри, то можно было убрать из кода
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        return true;
    }

  public function afterSave($insert, $changedAttributes)
  {
    parent::afterSave($insert, $changedAttributes);

        if ($this->imageFile) {
            $uploadPath = Yii::getAlias('@webroot/uploads/films/'); // TODO для идеала можно было добавить alias в web.php @uploads => '@web/uploads/films/'

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
        //TODO: можно было добавить еще проверку на существование файла

        return Yii::getAlias('@web/uploads/films/') // TODO для идеала можно было добавить alias
            . $this->id . '.' . $this->photo_ext;
    }
}
