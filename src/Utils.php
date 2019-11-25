<?php

namespace NayZawOo\PdfToImage;

class Utils
{
    public static function getPdfPageCount($pdfPath)
    {
        $os = strtolower(trim(php_uname('s')));
        if ($os === 'darwin') {
            $cmd = "/usr/bin/mdls -name kMDItemNumberOfPages -raw";
            exec("{$cmd} {$pdfPath}", $output);

            return (int) $output;
        }

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
