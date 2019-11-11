<?php

namespace NayZawOo\PdfToImage\Tests;

use NayZawOo\PdfToImage\PDF;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    use TestHelper;

    private $sourcePath = __DIR__.'/../data/red-green-blue-black.pdf';

    protected function setUp()
    {
        parent::setUp();
        $this->deleteTestFiles();
    }

    /**
     * @throws \NayZawOo\PdfToImage\Exceptions\FileNotFoundException
     * @throws \NayZawOo\PdfToImage\Exceptions\InvalidOutputFormatException
     */
    public function test_convert_pdf_to_jpg_and_png()
    {
        // test default pages
        $outputPath = __DIR__.'/../storage/red.jpg';
        $pdf = new PDF($this->sourcePath);

        $pdf->saveAsImage($outputPath);

        $this->assertTrue(file_exists($outputPath));
        $this->assertImageMainColor($outputPath, 'red', 'first page output image color should equal red');

        // test each pages
        foreach (['jpg', 'png', 'jpeg'] as $imageFormat) {
            foreach (['red', 'green', 'blue', 'black'] as $i => $color) {
                $outputPath = __DIR__.'/../storage/'.$color.'.'.$imageFormat;

                $pdf = new PDF($this->sourcePath, [
                    'page' => $i,
                ]);

                $pdf->saveAsImage($outputPath, [
                ]);

                $this->assertTrue(file_exists($outputPath));
                $this->assertImageMainColor($outputPath, $color, 'output image main color should equal'.$color);
            }
        }
    }

    /**
     * @throws \NayZawOo\PdfToImage\Exceptions\FileNotFoundException
     * @throws \NayZawOo\PdfToImage\Exceptions\InvalidOutputFormatException
     */
    public function test_convert_to_all_page()
    {
        $pdf = new PDF($this->sourcePath, [
            'all_pages' => true,
        ]);

        $outputPath = __DIR__.'/../storage/all_pages.jpg';
        $pdf->saveAsImage($outputPath);

        $this->assertFileExists($outputPath);

        list($width, $height) = getimagesize($outputPath);

        $this->assertTrue($height > ($width * 3), 'four pages height is larger than 3x page width');

        $this->assertTrue($height < ($width * 4), 'black page is smaller than other pages');
    }

    /**
     * @throws \NayZawOo\PdfToImage\Exceptions\FileNotFoundException
     * @throws \NayZawOo\PdfToImage\Exceptions\InvalidOutputFormatException
     */
    public function test_converter_should_create_output_file()
    {
        $this->sourcePath = __DIR__.'/../data/red-green-blue-black.pdf';

        $converter = new PDF($this->sourcePath);
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
