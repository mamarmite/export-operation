<?php

namespace Backpack\ExportOperation\Exports;

use Backpack\ExportOperation\Exports\Traits\CrudExportable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;


class PdfCrudExport implements FromCollection
{
    use Exportable;
    use CrudExportable;
    
    public $crud;
    
    public function __construct($crud)
    {
        $this->crud = $crud;
    }
    
    public function collection()
    {
        if ($this->is_crud()) {
            $entries = $this->crud->getEntries();
            $chunks = $entries->chunk(25);
            
            return $this->map_collection_to_cruds_columns_setup($chunks[0]);
        }
    }
    
    public function view(): View
    {
        if ($this->is_crud())
        {
            $entries = $this->crud->getEntries();
            $chunks = $entries->chunk(25);
            
            $entries = $this->map_collection_to_cruds_columns_setup($chunks[0]);
            return view('export-operation::raw', [
                'headers' => $this->get_crud_columns_headers(),
                'entries' => $entries
            ]);
        }
        return "";
    }

    
    /**
     * Maatwebsite/excel need for the implementes of `Maatwebsite\Excel\Concerns\WithProperties`
     * @return array of the excel properties
     */
    public function properties(): array
    {
        return $this->get_current_crud_metas();
    }

}