<?php

use yii\db\Schema;
use yii\db\Migration;
use bupy7\activerecord\history\Module;

class m160102_154310_init extends Migration
{
    protected $tableName;
    
    public function init()
    {
        parent::init();
        $this->tableName = Module::getInstance()->tableName;
    }
    
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,
            'table_name' => Schema::TYPE_STRING . ' NOT NULL',
            'row_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'event' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_by' => Schema::TYPE_INTEGER,
            'field_name' => Schema::TYPE_STRING,
            'old_value' => Schema::TYPE_TEXT,
            'new_value' => Schema::TYPE_TEXT,
        ], $tableOptions);
        $this->createIndex('index-1', $this->tableName, 'table_name');
        $this->createIndex('index-2', $this->tableName, ['table_name', 'row_id']);
        $this->createIndex('index-3', $this->tableName, ['table_name', 'field_name']);
        $this->createIndex('index-4', $this->tableName, 'event');
    }

    public function down()
    {
        $this->dropTable($this->tableName);
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
