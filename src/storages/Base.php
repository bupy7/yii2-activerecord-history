<?php

namespace bupy7\activerecord\history\storages;

use Yii;
use bupy7\activerecord\history\base\BaseObject;
use bupy7\activerecord\history\entities\History;
use bupy7\activerecord\history\interfaces\Storage as StorageInterface;

/**
 * Base class of storage via which must be extends all storage classes.
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
abstract class Base extends BaseObject implements StorageInterface
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
