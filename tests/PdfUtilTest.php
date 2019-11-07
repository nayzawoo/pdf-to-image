<?php

namespace NayZawOo\PdfToImage\Tests;

use NayZawOo\PdfToImage\Utils;
use PHPUnit\Framework\TestCase;

class PdfUtilTest extends TestCase
{
    public function test_get_pdf_pages_counts()
    {
        $sourcePath = __DIR__.'/../data/red-green-blue-black.pdf';
        $pageCount = Utils::getPdfPageCount($sourcePath);

        $this->assertEquals(4, $pageCount);
    }
}
