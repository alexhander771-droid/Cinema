<?php
use yii\db\Migration;

class m240106_000004_create_admin_user extends Migration
{
    public function safeUp()
    {
   
        $adminExists = (new \yii\db\Query())
            ->from('{{%user}}')
            ->where(['username' => 'admin'])
            ->exists();

        if (!$adminExists) {

            $this->insert('{{%user}}', [
                'username' => 'admin',
                'password_hash' => Yii::$app->security->generatePasswordHash('admin123'),
                'auth_key' => Yii::$app->security->generateRandomString(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function safeDown()
    {
        $this->delete('{{%user}}', ['username' => 'admin']);
    }
}