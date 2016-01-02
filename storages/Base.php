<?php

namespace bupy7\activerecord\history\storages;

use Yii;
use yii\base\Object;
use bupy7\activerecord\history\models\History;
use bupy7\activerecord\history\interfaces\Storage as StorageInterface;

/**
 * Base class of storage via which must be extends all storage classes.
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
abstract class Base extends Object implements StorageInterface
{
    /**
     * @var History[] Changes collection of active record models.
     */
    protected $collection = [];
    
    /**
     * Add to changes collection of active record model.
     * @param History $model
     */
    public function add(History $model)
    {
        $this->collection[] = $model;
    }
    
    /**
     * Return changes collection of active record models.
     * @return History[]
     */
    public function getCollection()
    {
        return $this->collection;
    }
}