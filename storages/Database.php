<?php

namespace bupy7\activerecord\history\storages;

use Yii;
use bupy7\activerecord\history\models\History;
use bupy7\activerecord\history\storages\Base as BaseStorage;
use bupy7\activerecord\history\Module;

/**
 * Database storage history of changes.
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
class Database extends BaseStorage
{
    /**
     * @var Module Instance of history module class.
     */
    protected $module;
    
    /**
     * @inhertidoc
     */
    public function init()
    {
        parent::init();
        $this->module = Module::getInstance();
    }
    
    /**
     * @inheritdoc
     */
    public function flush()
    {          
        $collection = $this->getCollection();
        if (!empty($collection)) {
            list($sql, $params) = $this->prepareQuery($collection);
            return (bool)$this->module->db->createCommand($sql, $params)->execute();
        }
        return true;
    }
    
    /**
     * Prepare SQL query uses collection data.
     * @param History[] $collection Changes collection of active record models.
     * @return string
     */
    protected function prepareQuery(array $collection)
    {
        $queryBuilder = $this->module->db->getQueryBuilder();    
        $sql = [];
        $params = [];
        for ($i = 0; $i != count($collection); $i++) {
            $row = [
                'table_name' => $collection[$i]->table_name,
                'field_name' => $collection[$i]->field_name,
                'row_id' => $collection[$i]->row_id,
                'old_value' => $collection[$i]->old_value,
                'new_value' => $collection[$i]->new_value,
                'event' => $collection[$i]->event,
                'created_at' => $collection[$i]->created_at,
                'created_by' => $collection[$i]->created_by,
            ];
            $sql[] = $queryBuilder->insert($this->module->tableName, $row, $params);
        }       
        return [implode(';' . PHP_EOL, $sql), $params];
    }
}

