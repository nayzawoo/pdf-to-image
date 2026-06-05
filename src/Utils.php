<?php

declare(strict_types=1);

namespace NayZawOo\PdfToImage;

class Utils
{
    public static function command_exist(string $cmd): bool
    {
        $result = shell_exec(sprintf('which %s', escapeshellarg($cmd)));

        return $result !== null && trim($result) !== '';
    }

    public static function isOSx(): bool
    {
        $os = strtolower(trim(php_uname('s')));

        return $os === 'darwin';
    }

    public static function getPdfPageCount(string $pdfPath): int
    {
        $cmd = '/usr/bin/pdfinfo';
        if (!static::command_exist($cmd)) {
            throw new \Exception('Command not found: /usr/bin/pdfinfo. Check https://command-not-found.com/pdfinfo');
        }

        exec(sprintf('%s %s', escapeshellarg($cmd), escapeshellarg($pdfPath)), $output);

        $pageCount = 0;
        $output = implode('', $output);

        if (preg_match('/Pages:\s*(\d+)/i', $output, $matches) === 1) {
            return intval($matches[1], 10);
        }

        return $pageCount;
    }

    public static function getExtensionsFromPath(string $path): string
    {
        $outputExtension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        switch ($outputExtension) {
            case 'jpg':
            case 'jpeg':
                return ImageFormat::JPG;
            default:
                return ImageFormat::PNG;
        }
    }
}
