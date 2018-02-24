<?php

namespace bupy7\activerecord\history\entities;

use Yii;
use yii\base\Object;

/**
 * Entity of collection history changes active record model.
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
class History extends Object
{
    /**
     * Event types of history to the AR object: when insert row.
     */
    const EVENT_INSERT = 1;
    /**
     * Event types of history to the AR object: when update row.
     */
    const EVENT_UPDATE = 2;
    /**
     * Event types of history to the AR object: when delete row.
     */
    const EVENT_DELETE = 3;
    
    /**
     * @var string Name of table where has been created or updated field.
     */
    public $tableName;
    /**
     * @var integer Id of row where has been created or updated field.
     */
    public $rowId;
    /**
     * @var string Name change of field.
     */
    public $fieldName;
    /**
     * @var string Old value of field before updated field.
     */
    public $oldValue;
    /**
     * @var string New value of field after created or updated field.
     */
    public $newValue;
    /**
     * @var integer Event type of history to the AR object.
     */
    public $event;
    /**
     * @var integer Timestamp of create or update field.
     */
    public $createdAt;
    /**
     * @var integer Id of user which created or updated field.
     */
    public $createdBy;
}
