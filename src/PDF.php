<?php

declare(strict_types=1);

namespace NayZawOo\PdfToImage;

use NayZawOo\PdfToImage\Exceptions\FileNotFoundException;
use NayZawOo\PdfToImage\Exceptions\InvalidOutputFormatException;

class PDF
{
    private string $sourcePath;
    private array $sourceOptions;
    private VipsAdapterInterface $vips;

    public function __construct(string $sourcePath, array $sourceOptions = [], ?VipsAdapterInterface $vips = null)
    {
        $this->sourcePath = $sourcePath;
        $this->sourceOptions = $sourceOptions;
        $this->vips = $vips ?? new VipsAdapter();
    }

    public function saveAsImage(string $path, array $options = []): void
    {
        if (!file_exists($this->sourcePath)) {
            throw new FileNotFoundException("No such file or directory {$this->sourcePath}");
        }

        $extension = Utils::getExtensionsFromPath($path);

        $sourceOptions = $this->getSourceOptions($this->sourceOptions);
        $outputOptions = $this->getOutputOptions($options, $extension);

        $pdf = $this->vips->pdfload($this->sourcePath, $sourceOptions);

        if ($extension === ImageFormat::JPG) {
            $pdf->jpegsave($path, $outputOptions);

            return;
        }

        if ($extension === ImageFormat::PNG) {
            $pdf->pngsave($path, $outputOptions);

            return;
        }

        throw new InvalidOutputFormatException("Invalid output image format: \"{$extension}\"");
    }

    protected function getSourceOptions(array $options): array
    {
        $sourceOptions = $this->arrayOnly($options, [
            'page',
            'dpi',
            'n',
        ]);

        $sourceOptions['page'] = $sourceOptions['page'] ?? 0;
        $sourceOptions['dpi'] = $sourceOptions['dpi'] ?? 300;
        $sourceOptions['n'] = $sourceOptions['n'] ?? 1;

        if (!empty($options['all_pages'])) {
            $sourceOptions['n'] = -1;
        }

        return $sourceOptions;
    }

    protected function getOutputOptions(array $options, string $extension): array
    {
        if ($extension === ImageFormat::JPG) {
            return $this->arrayOnly($options, [
                'Q',
                'profile',
                'optimize_coding',
                'interlace',
                'strip',
                'no_subsample',
                'trellis_quant',
                'overshoot_deringing',
                'optimize_scans',
                'quant_table',
            ]);
        }

        return $this->arrayOnly($options, [
            'compression', // compression level 0 - 9, Default 6
            'interlace',
            'profile',
            'filter',
            'palette',
            'colours',
            'Q',
            'dither',
        ]);
    }

    protected function arrayOnly(array $array, array $keys): array
    {
        return array_intersect_key($array, array_flip($keys));
    }
}
