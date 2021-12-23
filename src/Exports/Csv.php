<?php

namespace Backpack\ExportOperation\Exports;

class Csv implements ExportInterface
{

    public static function getHeaders(string $fileName): array
    {
        return [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName; charset=utf-8",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];
    }
    
    public static function getFileExtension(): string
    {
        return "csv";
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