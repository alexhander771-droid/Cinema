<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;

class UserController extends Controller
{
  /**
   * @param string 
   * @param string 
   * @return int 
   */
  public function actionCreateAdmin($username, $password)
  {
    $user = new User();
    $user->username = $username;
    $user->setPassword($password);
    $user->generateAuthKey();

    if ($user->save()) {
      echo "✅ Администратор создан успешно!\n";
      echo "Логин: $username\n";
      echo "Пароль: $password\n";
      return ExitCode::OK;
    } else {
      echo "❌ Ошибка при создании администратора:\n";
      foreach ($user->errors as $errors) {
        foreach ($errors as $error) {
          echo " - $error\n";
        }
      }
      return ExitCode::UNSPECIFIED_ERROR;
    }
  }
}
