<?php

declare(strict_types=1);

namespace NayZawOo\PdfToImage;

interface VipsAdapterInterface
{
    public function pdfload(string $sourcePath, array $options): object;
}
