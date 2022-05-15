<?php

/**
 * Export operation config.
 */
return [
    
    //package use theses
    'default' => 'csv',
    'supported' => ['csv', 'excel'],
    'line-ending' => '',
    
    // Drivers config.
    'csv' => [
        'file-extension' => 'csv',
        'line-ending' => 'default',
        'headers' => [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=filename; charset=utf-8",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ],
    ],
    
    'excel' => [
        'file-extension' => 'xls',
        'line-ending' => 'default',
        'headers' => [
            "Content-Type: application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=filename; charset=utf-8",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ],
    ],
    
    'pdf' => [
        'file-extension' => 'pdf',
        'line-ending' => 'default',
        'headers' => [
            "Content-Type: application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=filename; charset=utf-8",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ],
    ]
];