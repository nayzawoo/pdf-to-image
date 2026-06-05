<?php

declare(strict_types=1);

namespace NayZawOo\PdfToImage;

use Jcupitt\Vips;

class VipsAdapter implements VipsAdapterInterface
{
    public function pdfload(string $sourcePath, array $options): object
    {
        return Vips\Image::pdfload($sourcePath, $options);
    }
}
