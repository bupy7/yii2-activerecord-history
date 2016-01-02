<?php

namespace bupy7\activerecord\history\models;

use Yii;
use yii\base\Model;

/**
 * 
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
class History extends Model
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
    public $table_name;
    /**
     * @var integer Id of row where has been created or updated field. 
     */
    public $row_id;
    /**
     * @var string Name change of field.
     */
    public $field_name;
    /**
     * @var string Old value of field before updated field.
     */
    public $old_value;
    /**
     * @var string New value of field after created or updated field.
     */
    public $new_value;
    /**
     * @var integer Event type of history to the AR object.
     */
    public $event;
    /**
     * @var integer Timestamp of create or update field.
     */
    public $created_at;
    /**
     * @var integer Id of user which created or updated field.
     */
    public $created_by;
}

