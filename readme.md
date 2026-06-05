# PDF to Image

[![Tests](https://github.com/nayzawoo/pdf-to-image/actions/workflows/test.yml/badge.svg)](https://github.com/nayzawoo/pdf-to-image/actions/workflows/test.yml)
[![License](https://img.shields.io/github/license/nayzawoo/pdf-to-image.svg)](LICENSE)

A high-performance PHP library to convert PDF pages to JPG/PNG images using [libvips](https://github.com/libvips/libvips) via [php-vips](https://github.com/libvips/php-vips).

---

## Why libvips?

libvips is an extremely fast image processing library with a very low memory footprint. Unlike ImageMagick, it does not load the entire image into memory, making it highly efficient for converting large, multi-page PDFs to images.

---

## Requirements

- **libvips** C library ([installation instructions](https://github.com/libvips/php-vips#install))
- **PHP** >= 8.5 (with FFI support enabled)

---

## Installation

Install the package via Composer:

```bash
composer require nayzawoo/pdf-to-image
```

---

## Usage

### Basic Example

```php
<?php

use NayZawOo\PdfToImage\PDF;

// Instantiate the converter with the PDF path and options
$pdf = new PDF('source.pdf', [
    'dpi' => 150,
]);

// Convert and save
$pdf->saveAsImage('output.png');
```

---

## Options

### 1. PDF Load Options (Constructor)

Pass load options as an associative array to the second argument of the constructor:

```php
$pdf = new PDF('source.pdf', [
    'page'      => 0,   // Page index to load (0-indexed)
    'dpi'       => 300, // Resolution for rendering
    'n'         => 1,   // Number of pages to load
    'all_pages' => true // Shortcut to load all pages (sets n to -1)
]);
```

- **`page`** (int): The page number to extract (starts at `0`). Default is `0`.
- **`dpi`** (int): The rendering resolution (dots per inch). Higher values result in higher quality and larger image sizes. Default is `300`.
- **`n`** (int): The number of pages to load. Default is `1`.
- **`all_pages`** (bool): If set to `true`, it overrides `n` and tells libvips to load all pages.

### 2. Save / Output Options

Pass output options as an associative array to the second argument of `saveAsImage()`:

#### For JPEG Output (`.jpg`, `.jpeg`):

```php
$pdf->saveAsImage('output.jpg', [
    'Q'               => 80,   // Quality factor (0-100)
    'strip'           => true, // Strip metadata from output
    'optimize_coding' => true, // Optimize Huffman coding tables
    'interlace'       => true  // Progressive JPEG output
]);
```

- **`Q`** (int): JPEG quality factor (0–100). Default is `75`.
- **`strip`** (bool): Strip all metadata profiles from the image. Default is `false`.
- **`optimize_coding`** (bool): Compute optimal Huffman coding tables. Default is `false`.
- **`interlace`** (bool): Save as progressive JPEG. Default is `false`.

#### For PNG Output (`.png`):

```php
$pdf->saveAsImage('output.png', [
    'compression' => 6,    // Compression level (0-9)
    'interlace'   => true, // Progressive/interlaced PNG output
]);
```

- **`compression`** (int): Zlib compression level (0–9). Default is `6`.
- **`interlace`** (bool): Save using Adam7 interlacing. Default is `false`.

---

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.
