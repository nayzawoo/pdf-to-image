<?php

namespace NayZawOo\PdfToImage\Tests;

use NayZawOo\PdfToImage\Converter;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    use TestHelper;

    protected function setUp()
    {
        parent::setUp();
        $this->deleteTestFiles();
    }

    public function test_convert_pdf_to_jpg()
    {
        $sourcePath = __DIR__.'/../data/red-green-blue-black.pdf';

        $converter = new Converter($sourcePath);

        foreach (['jpg', 'jpeg', 'png'] as $imageFormat) {
            foreach (['red', 'green', 'blue', 'black'] as $i => $color) {
                $outputPath = __DIR__.'/../storage/'.$color.'.'.$imageFormat;

                $converter->saveAsImage($outputPath, [
                    'page' => $i,
                ]);

                $this->assertTrue(file_exists($outputPath));
                $this->assertImageMainColor($outputPath, $color, 'output image color should equal'.$color);
            }
        }

        $outputPath = __DIR__.'/../storage/red.jpg';
        $converter->saveAsImage($outputPath);

        $this->assertTrue(file_exists($outputPath));
        $this->assertImageMainColor($outputPath, 'red', 'first page output image color should equal red');
    }

    public function test_converter_should_create_output_file()
    {
        $sourcePath = __DIR__.'/../data/red-green-blue-black.pdf';

        $converter = new Converter($sourcePath);
        $outputPath = __DIR__.'/../storage/first_page_is_red.png';
        $converter->saveAsImage($outputPath);
        $this->assertTrue(file_exists($outputPath));
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->deleteTestFiles();
    }
}
