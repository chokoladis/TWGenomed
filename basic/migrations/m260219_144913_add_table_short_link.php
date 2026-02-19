<?php

use yii\db\Migration;

class m260219_144913_add_table_short_link extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('short_links', [
            'id' => $this->primaryKey(),
            'link' => $this->string()->notNull()->unique(),
            'short_link' => $this->string(30)->notNull()->unique(),
            'qr_code_path' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('short_links');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260219_144913_add_table_short_link cannot be reverted.\n";

        return false;
    }
    */
}
