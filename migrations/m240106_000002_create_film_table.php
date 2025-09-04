<?php
use yii\db\Migration;

class m240106_000002_create_film_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%film}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'photo_ext' => $this->string(10)->null(),
            'description' => $this->text()->null(),
            'duration' => $this->integer()->notNull(),
            'age_restriction' => $this->string(10)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%film}}');
    }
}