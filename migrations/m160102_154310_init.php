<?php

use yii\db\Schema;
use yii\db\Migration;
use bupy7\activerecord\history\Module;

class m160102_154310_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $tableName = Module::getInstance()->tableName;
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'table_name' => Schema::TYPE_STRING . ' NOT NULL',
            'row_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'event' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER,
            'field_name' => Schema::TYPE_STRING,
            'old_value' => Schema::TYPE_TEXT,
            'new_value' => Schema::TYPE_TEXT,
        ]);
        $this->createIndex('index-1', $tableName, 'table_name');
        $this->createIndex('index-2', $tableName, ['table_name', 'row_id']);
        $this->createIndex('index-2', $tableName, ['table_name', 'field_name']);
        $this->createIndex('index-3', $tableName, 'event');
    }

    public function down()
    {
        echo "m160102_154310_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
