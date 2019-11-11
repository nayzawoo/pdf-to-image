<?php

namespace NayZawOo\PdfToImage;

use Jcupitt\Vips;
use NayZawOo\PdfToImage\Exceptions\FileNotFoundException;
use NayZawOo\PdfToImage\Exceptions\InvalidOutputFormatException;

class PDF
{
    /**
     * @var array
     */
    private $sourcePath;

    private $sourceOptions;

    /**
     * Converter constructor.
     *
     * @param string $sourcePath
     * @param $sourceOptions
     */
    public function __construct($sourcePath, $sourceOptions = [])
    {
        $this->sourcePath = $sourcePath;
        $this->sourceOptions = $sourceOptions;
    }

    /**
     * @param $path
     * @param array $options
     * @return null
     * @throws \NayZawOo\PdfToImage\Exceptions\InvalidOutputFormatException
     * @throws \NayZawOo\PdfToImage\Exceptions\FileNotFoundException
     */
    public function saveAsImage($path, $options = [])
    {
        if (!file_exists($this->sourcePath)) {
            throw new FileNotFoundException("No such file or directory ".$this->sourcePath);
        }

        $extension = Utils::getExtensionsFromPath($path);

        $sourceOptions = $this->getSourceOptions($this->sourceOptions);
        $outputOptions = $this->getOutputOptions($options, $extension);

        $pdf = Vips\Image::pdfload($this->sourcePath, $sourceOptions);

        if ($extension === ImageFormat::JPG) {
            $pdf->jpegsave($path, $outputOptions);

            return null;
        } elseif ($extension === ImageFormat::PNG) {
            $pdf->pngsave($path, $outputOptions);

            return null;
        }

        throw new InvalidOutputFormatException("Invalid output image format: \"".$extension."\"");
    }

    protected function getSourceOptions($options)
    {
        $sourceOptions = $this->arrayOnly($options, [
            'page',
            'dpi',
            'n',
        ]);

        $sourceOptions['page'] = $sourceOptions['page'] ?? 0;
        $sourceOptions['dpi'] = $sourceOptions['dpi'] ?? 300;
        $sourceOptions['n'] = $sourceOptions['n'] ?? 1;

        if (isset($options['all_pages']) && $options['all_pages']) {
            $sourceOptions['n'] = -1;
        }

        return $sourceOptions;
    }

    protected function getOutputOptions($options, $extension)
    {
        if ($extension == ImageFormat::JPG) {
            $outputOptions = $this->arrayOnly($options, [
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
        } else {
            $outputOptions = $this->arrayOnly($options, [
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

        return $outputOptions;
    }

    protected function arrayOnly($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }
}
