<?php

namespace bupy7\activerecord\history\tests;

use InvalidArgumentException;

class Env
{
    /**
     * @var array
     */
    private $params;
    /**
     * @var
     */
    private static $instance;

    private function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return Env
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Env($_ENV);
        }
        return self::$instance;
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->get('db_name');
    }

    /**
     * @return string
     */
    public function getDbUsername()
    {
        return $this->get('db_username');
    }

    /**
     * @return string
     */
    public function getDbPassword()
    {
        return $this->get('db_password');
    }

    /**
     * @return string
     */
    public function getDbHost()
    {
        return $this->get('db_host');
    }

    /**
     * @return string|int
     */
    public function getDbPort()
    {
        return $this->get('db_port');
    }

    /**
     * @param string $name
     * @return string|int
     * @throw InvalidArgumentException
     */
    private function get($name)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }
        throw new InvalidArgumentException('Specified name of `' . $name . '` not exists.');
    }
}
