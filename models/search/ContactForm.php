<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;

    /**
     * @return array
     */

    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required', 'message' => 'Поле обязательно для заполнения.'],
            ['email', 'email', 'message' => 'Введите корректный email.'],
            ['verifyCode', 'captcha', 'message' => 'Неверный код проверки.'],
        ];
    }


    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'subject' => 'Тема',
            'body' => 'Сообщение',
            'verifyCode' => 'Код проверки',
        ];
    }

    /**
     * Отправляет email
     * @param string $email получатель
     * @return bool успех отправки
     */
    public function contact($email)
    {
        if ($this->validate()) {
            return Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
        }
        return false;
    }
}