<?php
namespace Backpack\ExportOperation\Exports\Traits;

use Illuminate\Support\Collection;

trait CrudExportable {
    
    public $crud;
    
    /**
     * @return array
     */
    public function get_crud_columns_headers(): array
    {
        if ($this->is_crud()) {
            
            //  Get the columns setup in the operation setup function.
            //  idea add params to the column to be parsed and used for exporting.
            $columns = $this->crud->columns();
            
            //  Setup the head of the file.
            $head = [];
            foreach ($columns as $column_id => $column_params) {
                $head[] = $column_params["name"];
            }
            return $head;
        }
    }
    
    
    /**
     * @param $collection
     * @return \Illuminate\Support\Collection
     */
    public function map_collection_to_cruds_columns_setup(Collection $collection): Collection
    {
        $rows = [];
        if ($this->is_crud())
        {
            $columns = $this->crud->columns();
            foreach ($collection as $entry) {
                $row = [];
                foreach ($columns as $column_id => $column_params) {
                    $row[$column_id] = $this->translateColumnToString($column_params, $entry, $column_id);
                }
                $rows[] = $row;
            }
        }
        return collect($rows);
    }
    
    
    /**
     * Assume the target mehtod of the item if it's a relationship, it's name.
     * @param $column_params array The parameters of the column.
     * @param $entry_column  mixed the column value from the entries, could be multiple thing. mixed is php 8. So kept that only in comment.
     * @return string the column value as string for all.
     */
    protected function translateColumnToString(array $column, $entry, $entryProperty): string
    {
        if (isset($column['type']))
        {
            switch ($column['type']) {
                case 'relationship':
                    
                    $column['escaped'] = $column['escaped'] ?? true;
                    $column['prefix'] = $column['prefix'] ?? '';
                    $column['suffix'] = $column['suffix'] ?? '';
                    $column['limit'] = $column['limit'] ?? 40;
                    $column['attribute'] = $column['attribute'] ?? (new $column['model'])->identifiableAttribute();
                    
                    $attributes = $this->crud->getRelatedEntriesAttributes($entry, $column['entity'], $column['attribute']);
                    
                    $return_value = "";
                    foreach ($attributes as $key => $value) {
                        $return_value .= $value;
                    }
                    return $return_value;
            }
        }
        return $entry->$entryProperty ?? "";
    }
    
    protected function get_current_crud_metas()
    {
        return [
            'creator'        => config("app.name"),
            'lastModifiedBy' => config("app.name"),
            'title'          => $this->crud->entity_name_plural,
            'description'    => $this->crud->entity_name_plural,
            'subject'        => $this->crud->entity_name_plural,
            'keywords'       => $this->crud->entity_name_plural,
            'category'       => $this->crud->entity_name_plural,
            'manager'        => config("app.name"),
            'company'        => config("app.name"),
        ];
    }
    
    
    protected function is_crud()
    {
        return isset($this->crud) && $this->crud;
    }
}