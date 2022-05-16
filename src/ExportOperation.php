<?php

namespace Backpack\ExportOperation;

use Backpack\ExportOperation\Exports\CrudExport;
use Backpack\ExportOperation\Exports\PdfCrudExport;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
        // allow access to the operation
        if ($this->is_permissionmanager_installed()) {
            $this->crud->allowAccess('export');
        }
    
        Route::get($segment . '/export/viewAll', [
            'as' => $routeName . '.exportView',
            'uses' => $controller . '@viewAllEntries',
            'operation' => 'export',
        ]);
        
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
        if ($this->is_permissionmanager_installed()) {
            $this->crud->allowAccess('export');
        }
        
        $this->crud->operation('export', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig('backpack.export');
        });
        
        $this->crud->operation(['list', 'show'], function () {
            // add a button in the line stack
            $this->crud->addButton('top', 'export', 'view', 'export-operation::buttons.export', 'end');
        });
    }
    
    
    //  Routes methods
    
    /**
     * This is a route Method
     * @param string $type the file type (csv, excel, pdf)
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    protected function export($type=null)
    {
        // allow access to the operation
        if ($this->is_permissionmanager_installed())
        {
            $this->crud->allowAccess('export');
        }
        $format_type = $type ?? $this->default_export_format;
        
        //  Construct the filename for the file.
        //  @todo add configuration to build the file as the user need. Date or no Date, date format, parameter in the setup function ?
        $fileName = \Carbon\Carbon::now()->setTimezone(config('app.timezone'))->format('Ymd-Hi-') .
            Str::slug(config('backpack.base.project_name')) . '-' .
            Str::slug($this->crud->entity_name_plural) .
            "." .
            $this->getFileExtension($format_type);
        
        
        if ($format_type === 'excel' ||
            $format_type === 'csv')
        {
            $export = new CrudExport($this->crud);
            return $export->download($fileName);
        }
        
        if ($format_type === 'pdf')
        {
            $export = new PdfCrudExport($this->crud);
            return $export->download($fileName);
        }
    }
    
    public function viewAllEntries()
    {
        $export = new PdfCrudExport($this->crud);
        return $export->view();
    }
    
    
    /**
     * Managing the extension text for the downloadable file
     * @param string $type System type
     * @return String the file type according to the system type.
     */
    protected function getFileExtension($type = "csv"): string
    {
        return $this->callMethodOnDriver($type, 'getFileExtension') ?? "";
    }
    
    
    /**
     * Version 1 of lazy factory for file type export.
     * @param string $exportClass
     * @param string $method
     * @return mixed|null
     */
    private function callMethodOnDriver(string $exportClass, string $method, $params=null)
    {
        $class = __NAMESPACE__.'\\Exports\\Drivers\\'. Str::studly($exportClass);
        if (class_exists($class)) {
            return $class::$method($params);
        }
        return null;
    }
    
    
    /**
     * Wall to prepare the implementation of permission manager.
     * @return bool
     */
    private function is_permissionmanager_installed():bool {
        return false;
    }

}
