<?php

namespace Backpack\ExportOperation;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\File;

trait ExportOperation
{
    protected $default_export_format = 'csv';
    
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupExportOperationRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/export', [
            'as' => $routeName . '.export',
            'uses' => $controller . '@export',
            'operation' => 'export',
        ]);
        Route::get($segment . '/export/{type}', [
            'as' => $routeName . '.export',
            'uses' => $controller . '@export',
            'operation' => 'export',
        ]);
    }
    
    
    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupExportDefaults()
    {
        // allow access to the operation
        //$this->crud->allowAccess('export');
        
        $this->crud->operation('export', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });
        
        $this->crud->operation(['list', 'show'], function () {
            // add a button in the line stack
            $this->crud->addButton('top', 'export', 'view', 'export-operation::buttons.export', 'end');
        });
    }
    
    
    //  Routes methods
    
    /**
     * Gets items from database and returns to selects.
     *
     * @param string|array $arg
     * @return \Symfony\Component\HttpFoundation\StreamedResponse the file streamed.
     */
    protected function export($type = null)
    {
        // allow access to the operation uri
        //$this->crud->allowAccess('export');
        
        // the target entries. Here would be logic to manage the prefered sources of data.
        $entries = $this->crud->getEntries();//$this->crud->model->get();
        
        // Args : type export ?
        $format_type = $type ?? $this->default_export_format;
        
        //  Get the columns setup in the operation setup function.
        //  idea add params to the column to be parsed and used for exporting.
        $columns = $this->crud->columns();
        
        //  Setup the head of the file.
        //  @todo setup config to set the head as column property or label for now.
        $columns_labeled = [];
        foreach ($columns as $column_id => $column_params) {
            $columns_labeled[] = $column_params["name"];
        }
        
        //  Construct the filename for the file.
        //  @todo add configuration to build the file as the user need. Date or no Date, date format, parameter in the setup function ?
        $fileName = \Carbon\Carbon::now()->setTimezone('America/Montreal')->format('Ymd-Hi-') .
            Str::slug(config('backpack.base.project_name')) . '-' .
            Str::slug($this->crud->entity_name_plural) .
            "." .
            $this->getFileExtension($format_type);
        
        return response()->streamDownload(
            $this->generateFile($entries, $columns_labeled, $columns),
            $fileName
        );
    }
    
    
    /**
     * Before implementing exporting library, this is the file construction function callable for stream
     * @param Collection $entries All the entries to be exported
     * @param array $head The first row head values
     * @param array $structure The columns name return by the Crud object
     * @param string $type the system type.
     * @return callable The callable method with the file to be stream to the user.
     */
    protected function generateFile($entries, $head, $columns, $type = 'csv'): callable
    {
        $callback = function () use ($entries, $head, $columns, $type) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $head);
            
            foreach ($entries as $entry) {
                $row = [];
                foreach ($columns as $column_id => $column_params)
                {
                    $row[$column_id] = $this->translateColumnToString($column_params, $entry, $column_id);
                }
                fputcsv($file, $row);
                break;
            }
            
            fclose($file);
        };
        return $callback;
    }
    
    
    /**
     * Construct the appropriate headers for the target file's type according to the system.
     * For now only csv is implemented.
     * @param $fileName the file name
     * @param string $type the system type.
     * @return string[] the headers in an array of strings
     */
    protected function getFilesHeader($fileName, $type = 'csv')
    {
        return [
            "Content-type" => "text/$type",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
    }
    
    
    /**
     * Managing the extension text for the downloadable file
     * @param string $type System type
     * @return String the file type according to the system type.
     */
    protected function getFileExtension($type = "csv"): string
    {
        return $type;
    }
    
    
    /**
     * Assume the target mehtod of the item if it's a relationship, it's name.
     * @param $column_params array The parameters of the column.
     * @param $entry_column  mixed the column value from the entries, could be multiple thing. mixed is php 8. So kept that only in comment.
     * @return string the column value as string for all.
     */
    protected function translateColumnToString(array $column, $entry, $entryProperty): string
    {
        if (isset($column['type'])) {
            switch ($column['type']) {
                case 'relationship':
                    
                    $column['escaped'] = $column['escaped'] ?? true;
                    $column['prefix'] = $column['prefix'] ?? '';
                    $column['suffix'] = $column['suffix'] ?? '';
                    $column['limit'] = $column['limit'] ?? 40;
                    $column['attribute'] = $column['attribute'] ?? (new $column['model'])->identifiableAttribute();
                    
                    $attributes = $this->crud->getRelatedEntriesAttributes($entry, $column['entity'], $column['attribute']);
                    ray($attributes);
                    $return_value = "";
                    foreach ($attributes as $key => $value) {
                        $return_value .= $value;
                    }
                    return $return_value;
                    break;
            }
        }
        return $entry->$entryProperty ?? "";
    }
}
