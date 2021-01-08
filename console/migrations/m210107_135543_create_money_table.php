<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%money}}`.
 */
class m210107_135543_create_money_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%money}}', [
            'id' => $this->primaryKey(),
            'from_price'=> $this->string()->notNull(),
            'amount'=> $this->string()->notNull(),
            'to_price'=> $this->string()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%money}}');
    }
}
