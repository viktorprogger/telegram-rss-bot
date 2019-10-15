<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%feeds}}`.
 */
class m191015_150724_create_feeds_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%feeds}}', [
            'id' => $this->primaryKey(),
            'hash' => $this->string(32)->notNull(),
            'processed' => $this->boolean()->notNull()->defaultValue(false),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%feeds}}');
    }
}
