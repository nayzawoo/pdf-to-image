<?php

namespace NayZawOo\PdfToImage;

use NayZawOo\PdfToImage\Exceptions\InvalidOutputFormatException;

class Converter
{
    /**
     * @var array
     */
    private $sourcePath;

    /**
     * @var string
     */
    private $sourceOptions;

    /**
     * Converter constructor.
     *
     * @param string $sourcePath
     * @param array $sourceOptions
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
     */
    public function saveAsImage($path, $options = [])
    {
        $page = $options['page'] ?? 0;

        $sourceOptions = array_merge($this->sourceOptions, [
            'page' => $page,
        ]);

        unset($options['page']);

        $pdf = \Jcupitt\Vips\Image::pdfload($this->sourcePath, $sourceOptions);

        $extension = Utils::getExtensionsFromPath($path);

        if ($extension === Constants::IMAGE_FORMAT_JPG) {
            $pdf->jpegsave($path, $options);

            return null;
        } elseif ($extension === Constants::IMAGE_FORMAT_PNG) {
            $pdf->pngsave($path, $options);

            return null;
        }

        throw new InvalidOutputFormatException("Invalid output image format: \"".$extension."\"");
    }
}
