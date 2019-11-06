# PDF to Image

Simple PDF file to image(jpj/pdf) using ([libvips](https://github.com/libvips/libvips), [php-vips](https://github.com/libvips/php-vips)) for my personal projects.

## Requirements

- *ext-vips* [-> installation](https://github.com/libvips/php-vips-ext#installing)
- *php*  `^7.1.3`

## Installation

```
$ composer require nayzawoo/pdf-to-image
```

```php
<?php

use NayZawOo\PdfToImage\Converter;

$converter = new Converter('example/source.pdf');
$converter->saveAsImage('example/output.png'); // output png
$converter->saveAsImage('example/output.jpg'); // output jpg
$converter->saveAsImage('example/output.jpeg'); // output jpg

// convert second page
$converter->saveAsImage('example/output.jpeg', [
    'page' => 1,
]);
```
