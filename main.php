<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    die("Please install composer and run 'composer install' !" . PHP_EOL);
}

function rglob($pattern = '*', $path = '', $flags = 0) {
    $paths = glob($path . '*', GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT);
    $files = glob($path . $pattern, $flags);
    foreach ($paths as $path) {
        $files = array_merge($files, rglob($pattern, $path, $flags));
    }
    return $files;
}

foreach (rglob('*.php', 'Emulator\\') as $filename) {
    require($filename);
}

use Emulator\Emulator;

Emulator::start();
