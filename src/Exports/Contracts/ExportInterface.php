<?php

namespace Backpack\ExportOperation\Exports\Contracts;


interface ExportInterface {
    
    public static function getHeaders(string $fileName): array;
    public static function getFileExtension(): string;
    public static function getLineEnding(): string;
    public static function encapsulateRow($row);
}