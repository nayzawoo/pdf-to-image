<?php

namespace NayZawOo\PdfToImage;

class Utils
{
    public static function getPdfPageCount($pdfPath)
    {
        $cmd = "/usr/bin/pdfinfo";

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
