<?php

namespace NayZawOo\PdfToImage\Tests;

use NayZawOo\PdfToImage\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    use TestHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->deleteTestFiles();
    }

    public function test_convert_pdf_to_jpg()
    {
        $sourcePath = __DIR__.'/../data/red-green-blue-black.pdf';

        $converter = new Converter($sourcePath);

        foreach (['red', 'green', 'blue', 'black'] as $i => $color) {
            $outputPath = __DIR__.'/../storage/'.$color.'.jpg';

            $converter->saveAsImage($outputPath, [
                'page' => $i,
            ]);

            $this->assertTrue(file_exists($outputPath));
            $this->assertColor($outputPath, $color, 'Assert For Color '.$color);
        }
    }

    public function test_converter_should_create_output_file()
    {
        $sourcePath = __DIR__.'/../data/red-green-blue-black.pdf';

        $converter = new Converter($sourcePath);
        $outputPath = __DIR__.'/../storage/first_page_is_red.png';
        $converter->saveAsImage($outputPath);
        $this->assertTrue(file_exists($outputPath));
    }

    public function test_pdf_pages_with_colors()
    {
        $sourcePath = __DIR__.'/../data/red-green-blue-black.pdf';

        $converter = new Converter($sourcePath);

        foreach (['red', 'green', 'blue', 'black'] as $i => $color) {
            $outputPath = __DIR__.'/../storage/'.$color.'.png';

            $converter->saveAsImage($outputPath, [
                'page' => $i,
            ]);

            $this->assertTrue(file_exists($outputPath));
            $this->assertColor($outputPath, $color, 'Assert for color: '.$color);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->deleteTestFiles();
    }
}
