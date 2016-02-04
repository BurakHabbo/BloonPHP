<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

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
