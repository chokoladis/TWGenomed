<?php

use yii\db\Migration;

class m260220_124739_add_table_redirect_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('short_link_redirect_log', [
            'id' => $this->primaryKey(),
            'url_id' => $this->integer()->notNull(),
            'ip_address' => $this->string(15)->notNull(),
            'datetime' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey('fk-short_link_redirect_log-url_id', 'short_link_redirect_log', 'url_id','short_links', 'id', 'NO ACTION', 'NO ACTION');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('short_link_redirect_log');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260220_124739_add_table_redirect_log cannot be reverted.\n";

        return false;
    }
    */
}
