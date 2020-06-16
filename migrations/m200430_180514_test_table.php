<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200430_180514_test_table
 */
class m200430_180514_test_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('test', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text(),
        ]);

        $this->insert('test', [
            'title' => 'test 1',
            'content' => 'content 1',
        ]);
        $this->insert('test', [
            'title' => 'test 2',
            'content' => 'content 2',
        ]);
        $this->insert('test', [
            'title' => 'test 3',
            'content' => 'content 3',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200430_180514_test_table cannot be reverted.\n";
        $this->dropTable('test');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200430_180514_test_table cannot be reverted.\n";

        return false;
    }
    */
}
