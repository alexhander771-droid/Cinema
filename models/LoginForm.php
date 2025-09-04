<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
  public $username;
  public $password;
  public $rememberMe = true;

  private $_user;

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['username', 'password'], 'required'],
      ['rememberMe', 'boolean'],
      ['password', 'validatePassword'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'username' => 'Логин',
      'password' => 'Пароль',
      'rememberMe' => 'Запомнить меня',
    ];
  }

  /**
   * @param string 
   * @param array 
   */
  public function validatePassword($attribute, $params)
  {
    if (!$this->hasErrors()) {
      $user = $this->getUser();
      if (!$user || !$user->validatePassword($this->password)) {
        $this->addError($attribute, 'Неверное имя пользователя или пароль.');
      }
    }
  }

  /**
   * @return bool 
   */
  public function login()
  {
    if ($this->validate()) {
      return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    return false;
  }

  /**
   * @return User|null
   */
  protected function getUser()
  {
    if ($this->_user === null) {
      $this->_user = User::findByUsername($this->username);
    }

    return $this->_user;
  }
}
