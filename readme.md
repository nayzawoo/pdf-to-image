# PDF to Image

Simple PDF to image(jpg/png) using ([libvips](https://github.com/libvips/libvips), [php-vips](https://github.com/libvips/php-vips)) for my personal projects.

## Requirements

- *ext-vips* [(installation)](https://github.com/libvips/php-vips-ext#installing)
- *php* >=7.0.11

## Installation

```
$ composer require nayzawoo/pdf-to-image
```

```php
<?php

use NayZawOo\PdfToImage\PDF;

$pdf = new PDF('example/source.pdf', [
    'dpi' => 70, // default 300
    'page' => 1, // convert second page, default: 0
    'all_pages' => true, // default: false
]);

$pdf->saveAsImage('example/output.png'); // output png
$pdf->saveAsImage('example/output.jpg'); // output jpg
$pdf->saveAsImage('example/output.jpeg'); // output jpg
```

## Options

- [Load PDF options](https://jcupitt.github.io/libvips/API/current/VipsForeignSave.html#vips-pdfload)
- [Output JPEG options](https://jcupitt.github.io/libvips/API/current/VipsForeignSave.html#vips-jpegsave)
- [Output PNG options](https://jcupitt.github.io/libvips/API/current/VipsForeignSave.html#vips-pngsave)
