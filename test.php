<?php
require 'vendor/autoload.php';
require 'vendor/yiisoft/yii2/Yii.php';

echo "Создание администратора...\n";

$dbConfig = [
        'class' => 'yii\db\Connection', 
    'dsn' => 'mysql:host=localhost;port=3306;dbname=cinema_schedule',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
];


$app = new yii\console\Application([
    'id' => 'admin-creator',
    'basePath' => __DIR__,
    'components' => [
        'db' => $dbConfig,
    ],
]);

try {
    Yii::$app->db->open();
    echo "✅ Подключение к базе успешно\n";
} catch (Exception $e) {
    die("❌ Ошибка подключения к базе: " . $e->getMessage() . "\n");
}

$user = new app\models\User();
$user->username = 'admin';
$user->email = 'admin@cinema.ru';
$user->setPassword('admin123');
$user->generateAuthKey();
$user->status = 10; 
$user->created_at = time(); 
$user->updated_at = time(); 

if ($user->save()) {
    echo "✅ Администратор успешно создан\n";
    echo "Логин: admin\n";
    echo "Пароль: admin123\n";
    echo "Email: admin@mail.ru\n";
} else {
    echo "❌ Ошибка при создании администратора:\n";
    print_r($user->errors);
}
    
