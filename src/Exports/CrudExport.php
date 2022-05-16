<?php

namespace Backpack\ExportOperation\Exports;

use Backpack\ExportOperation\Traits\CrudExportable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;


class CrudExport implements FromCollection, WithHeadings, WithProperties, WithCustomCsvSettings
{
    use Exportable;
    use CrudExportable;
    
    public function __construct($crud)
    {
        $this->crud = $crud;
    }
    
    
    public function collection()
    {
        return $this->map_collection_to_cruds_columns_setup($this->crud->getEntries());
    }
    
    
    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->get_crud_columns_headers();
    }
    
    /**
     * Maatwebsite/excel need for the implementes of `Maatwebsite\Excel\Concerns\WithProperties`
     * @return array of the excel properties
     */
    public function properties(): array
    {
        return $this->get_current_crud_metas();
    }
    
    
    /**
     * extends the Config/Excel object for some new data.
     * @return string[]
     */
    public function getCsvSettings(): array
    {
        return [
            "output_encoding" => "UTF-8"
        ];
    }
    
}