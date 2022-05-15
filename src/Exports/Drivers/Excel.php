<?php

namespace Backpack\ExportOperation\Exports\Drivers;


use Backpack\ExportOperation\Exports\Contracts\ExportInterface;

class Excel implements ExportInterface
{
    
    public static function getHeaders(string $fileName): array
    {
        return [
            "Content-Type: application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$fileName; charset=utf-8",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
    }
    
    public static function getFileExtension(): string
    {
        return "xls";
    }
    
    public static function getLineEnding(): string
    {
        return "";
    }
    
    public static function encapsulateRow($row)
    {
        return $row;
    }
}