<?php

use yii\db\Schema;
use yii\db\Migration;

class m180223_030800_post extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('post', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('post');
    }
}
