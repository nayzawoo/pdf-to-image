<?php

namespace NayZawOo\PdfToImage\Tests;

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

trait TestHelper
{
    protected function assertImageMainColor($path, $color, $prefixMessage)
    {
        $palette = Palette::fromFilename($path);
        $extractor = new ColorExtractor($palette);
        $mainColors = $extractor->extract(1)[0];
        $mainColors = Color::fromIntToRgb($mainColors);

        switch ($color) {
            case 'red':
                $this->assertGreaterThan(253, $mainColors['r'], $prefixMessage);
                $this->assertLessThan(2, $mainColors['g'], $prefixMessage);
                $this->assertLessThan(2, $mainColors['b'], $prefixMessage);
                break;

            case 'green':
                $this->assertGreaterThan(253, $mainColors['g'], $prefixMessage);
                $this->assertLessThan(2, $mainColors['r'], $prefixMessage);
                $this->assertLessThan(2, $mainColors['b'], $prefixMessage);
                break;

            case 'blue':
                $this->assertGreaterThan(253, $mainColors['b'], $prefixMessage);
                $this->assertLessThan(2, $mainColors['r'], $prefixMessage);
                $this->assertLessThan(2, $mainColors['g'], $prefixMessage);
                break;
            case 'black':
                $this->assertLessThan(2, $mainColors['b'], $prefixMessage);
                $this->assertLessThan(2, $mainColors['r'], $prefixMessage);
                $this->assertLessThan(2, $mainColors['g'], $prefixMessage);
                break;
        }
    }

    protected function deleteTestFiles()
    {
        $path = __DIR__.'/../storage/';

        foreach ([
                     'jpg',
                     'jpeg',
                     'png',
                 ] as $format) {
            foreach (glob($path.'*.'.$format) as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }
}
