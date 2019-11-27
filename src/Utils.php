<?php

namespace NayZawOo\PdfToImage;

class Utils
{
    public static function command_exist($cmd)
    {
        $return = shell_exec(sprintf("which %s", escapeshellarg($cmd)));

        return !empty($return);
    }

    public static function isOSx()
    {
        $os = strtolower(trim(php_uname('s')));

        return $os === 'darwin';
    }

    public static function getPdfPageCount($pdfPath)
    {
        $cmd = "/usr/bin/pdfinfo";
        if (!static::command_exist($cmd)) {
            throw new \Exception('Command not found: /usr/bin/pdfinfo. Check https://command-not-found.com/pdfinfo');
        }

        exec("{$cmd} {$pdfPath}", $output);

        $pageCount = 0;
        $output = implode("", $output);

        if (preg_match("/Pages:\s*(\d+)/i", $output, $matches) === 1) {
            return intval($matches[1]);
        }

        return $pageCount;
    }

    public static function getExtensionsFromPath($path)
    {
        $outputExtension = pathinfo($path, PATHINFO_EXTENSION);
        $outputExtension = strtolower($outputExtension);

        switch ($outputExtension) {
            case 'jpg':
            case 'jpeg':
                return ImageFormat::JPG;
            default:
                return ImageFormat::PNG;
        }
    }
}
