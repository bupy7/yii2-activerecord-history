<?php

namespace bupy7\activerecord\history\storages;

use Yii;
use bupy7\activerecord\history\storages\Base as BaseStorage;
use bupy7\activerecord\history\Module;

/**
 * 
 * @author Belosludcev Vasilij <https://github.com/bupy7>
 * @since 1.0.0
 */
class Database extends BaseStorage
{
    /**
     * @var Module
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
        return (bool)$this->module->db
            ->createCommand()
            ->batchInsert(
                $this->module->tableName,
                [
                    'table_name',
                    'field_name',
                    'row_id',
                    'old_value',
                    'new_value',
                    'event',
                    'created_at',
                    'created_by',
                ],
                $this->prepareRows($this->getCollection())
            )
            ->execute();
    }
    
    /**
     * 
     * @param array $collection
     * @return array
     */
    protected function prepareRows(array $collection)
    {
        $rows = [];
        foreach ($collection as $model)
        {
            $rows[] = [
                $model->table_name,
                $model->field_name,
                $model->row_id,
                $model->old_value,
                $model->new_value,
                $model->event,
                $model->created_at,
                $model->created_by,
            ];
        }
        return $rows;
    }
}

