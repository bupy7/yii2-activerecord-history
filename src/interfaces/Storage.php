<?php

namespace bupy7\activerecord\history\interfaces;

use Yii;

/**
 * Interface of storage for history of active record model.
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
interface Storage
{
    /**
     * Saving to storage changed models.
     * @return boolean
     */
    public function flush();
}
