<?php

namespace Backpack\ExportOperation\Exports\Drivers;


use Backpack\ExportOperation\Exports\Contracts\ExportInterface;

class Excel implements ExportInterface
{
    
    public static function getHeaders(string $fileName): array
    {
        return [];
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