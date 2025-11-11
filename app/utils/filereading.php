<?php

namespace App\utils;

use Illuminate\Support\Facades\Storage;

class FileReading
{
    public static function read($file, $delimiter = "\t") {
        $localFile = Storage::disk('local')->get($file);

        $encoding = mb_detect_encoding($localFile, ['UTF-8', 'ISO-8859-1', 'ISO-8859-2', 'Windows-1252'], true);
        if ($encoding && $encoding !== 'UTF-8') {
            $localFile = mb_convert_encoding($localFile, 'UTF-8', $encoding);
        }

        $rows = array_map(function($line) use ($delimiter) {
            return str_getcsv($line, $delimiter);
        }, explode("\n", $localFile));

        return array_filter($rows, function($row) {
            return !empty($row[0]);
        });
    }
}
