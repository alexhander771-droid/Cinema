<?php
use yii\db\Migration;

class m240106_000003_create_session_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%session}}', [
            'id' => $this->primaryKey(),
            'film_id' => $this->integer()->notNull(),
            'start_at' => $this->timestamp()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);

        $this->addForeignKey(
            'fk-session-film_id',
            '{{%session}}',
            'film_id',
            '{{%film}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-session-film_id', '{{%session}}');
        $this->dropTable('{{%session}}');
    }
}