<?php

declare(strict_types=1);

namespace NayZawOo\PdfToImage\Tests;

use NayZawOo\PdfToImage\PDF;
use NayZawOo\PdfToImage\VipsAdapterInterface;
use PHPUnit\Framework\TestCase;

class PDFTest extends TestCase
{
    private string $sourcePdf;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sourcePdf = sys_get_temp_dir() . '/pdf-to-image-source.pdf';
        touch($this->sourcePdf);
    }

    protected function tearDown(): void
    {
        @unlink($this->sourcePdf);

        parent::tearDown();
    }

    public function testSaveAsImageCreatesPngFromSamplePdf(): void
    {
        $pdfImage = $this->createMock(DummyPdfImage::class);

        $pdfImage->expects(self::once())
            ->method('pngsave')
            ->with(self::equalTo(sys_get_temp_dir() . '/sample-output.png'), self::isType('array'));

        $vipsAdapter = $this->createMock(VipsAdapterInterface::class);
        $vipsAdapter->expects(self::once())
            ->method('pdfload')
            ->with(self::equalTo($this->sourcePdf), self::arrayHasKey('dpi'))
            ->willReturn($pdfImage);

        $pdf = new PDF($this->sourcePdf, ['dpi' => 72, 'page' => 0], $vipsAdapter);
        self::assertInstanceOf(PDF::class, $pdf);

        $pdf->saveAsImage(sys_get_temp_dir() . '/sample-output.png');
    }

    public function testSaveAsImageCreatesJpgFromSamplePdf(): void
    {
        $pdfImage = $this->createMock(DummyPdfImage::class);

        $pdfImage->expects(self::once())
            ->method('jpegsave')
            ->with(self::equalTo(sys_get_temp_dir() . '/sample-output.jpg'), self::isType('array'));

        $vipsAdapter = $this->createMock(VipsAdapterInterface::class);
        $vipsAdapter->expects(self::once())
            ->method('pdfload')
            ->with(self::equalTo($this->sourcePdf), self::arrayHasKey('dpi'))
            ->willReturn($pdfImage);

        $pdf = new PDF($this->sourcePdf, ['dpi' => 72, 'page' => 0], $vipsAdapter);
        self::assertInstanceOf(PDF::class, $pdf);

        $pdf->saveAsImage(sys_get_temp_dir() . '/sample-output.jpg');
    }
}

class DummyPdfImage
{
    public function pngsave(string $path, array $options): void
    {
    }

    public function jpegsave(string $path, array $options): void
    {
    }
}
