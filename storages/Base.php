<?php

namespace bupy7\activerecord\history\storages;

use Yii;
use yii\base\Object;
use bupy7\activerecord\history\models\History;
use bupy7\activerecord\history\interfaces\Storage as StorageInterface;

/**
 * 
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1,0.0
 */
abstract class Base extends Object implements StorageInterface
{
    /**
     * @var array
     */
    protected $collection = [];
    
    /**
     * @param History $model
     */
    public function add(History $model)
    {
        $this->collection[] = $model;
    }
    
    /**
     * @return array
     */
    public function getCollection()
    {
        return $this->collection;
    }
}