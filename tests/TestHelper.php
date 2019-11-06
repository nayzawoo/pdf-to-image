<?php

namespace NayZawOo\PdfToImage\Tests;

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

trait TestHelper
{
    protected function assertColor($path, $color, $prefixMessage)
    {
        $palette = Palette::fromFilename($path);
        $extractor = new ColorExtractor($palette);
        $mainColors = $extractor->extract(1)[0];
        $mainColors = Color::fromIntToRgb($mainColors);

        switch ($color) {
            case 'red':
                $this->assertGreaterThan(250, $mainColors['r'], $prefixMessage);
                $this->assertLessThan(5, $mainColors['g'], $prefixMessage);
                $this->assertLessThan(5, $mainColors['b'], $prefixMessage);
                break;

            case 'green':
                $this->assertGreaterThan(250, $mainColors['g'], $prefixMessage);
                $this->assertLessThan(5, $mainColors['r'], $prefixMessage);
                $this->assertLessThan(5, $mainColors['b'], $prefixMessage);
                break;

            case 'blue':
                $this->assertGreaterThan(250, $mainColors['b'], $prefixMessage);
                $this->assertLessThan(5, $mainColors['r'], $prefixMessage);
                $this->assertLessThan(5, $mainColors['g'], $prefixMessage);
                break;
            case 'black':
                $this->assertLessThan(5, $mainColors['b'], $prefixMessage);
                $this->assertLessThan(5, $mainColors['r'], $prefixMessage);
                $this->assertLessThan(5, $mainColors['g'], $prefixMessage);
                break;
        }
    }

    protected function deleteTestFiles()
    {
        $path = __DIR__.'/../storage/';

        foreach ([
                     'jpg',
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
