<?php

namespace Backpack\ExportOperation;


use Illuminate\Support\ServiceProvider;

class ExportOperationServiceProvider extends ServiceProvider
{
    
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->register(ExportOperationServiceProvider::class);
        
    }
    
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //  Lang files
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'export-operation');

        //  Views
        $customExportOperationFolder = resource_path('views/vendor/backpack/export-operation');
    
        // - first the published/overwritten views (in case they have any changes)
        if (file_exists($customExportOperationFolder)) {
            $this->loadViewsFrom($customExportOperationFolder, 'export-operation');
        }
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'export-operation');
        
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        /* Return errors. Passing that to tech depts. @todo.
         * // Publishing the views.
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/backpack'),
        ], 'export-all-operation.views');
        
        // Publishing the translation files.
        $this->publishes([
            __DIR__.'/resources/lang' => resource_path('lang/vendor/backpack'),
        ], 'export-all-operation.lang');*/
    }
}
