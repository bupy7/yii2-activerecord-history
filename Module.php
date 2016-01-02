<?php

namespace bupy7\activerecord\history;

use Yii;
use yii\db\Connection;
use yii\di\Instance;
use yii\web\User;

/**
 * This extension adds storage history of changes to the ActiveRecord model.
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
class Module extends \yii\base\Module
{
    /**
     * @var string Table name of saving changes of model.
     */
    public $tableName = '{{%arhistory}}';
    /**
     * @var string Class name of storage for saving history of active record model.
     */
    public $storage = 'bupy7\activerecord\history\storages\Database';
    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
     * After the DbCache object is created, if you want to change this property, you should only assign it
     * with a DB connection object.
     */
    public $db = 'db';
    /**
     * @var User|array|string the user object representing the authentication status or the ID of the user 
     * application component.
     */
    public $user = 'user';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
        $this->user = Instance::ensure($this->user, User::className());
    }
}
