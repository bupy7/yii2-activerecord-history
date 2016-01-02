<?php

namespace bupy7\activerecord\history\interfaces;

use Yii;
use bupy7\activerecord\history\models\History;

/**
 * 
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
interface Storage
{
    /**
     * 
     * @param History $model
     */
    public function add(History $model);
    
    /**
     * @return boolean
     */
    public function flush();
}