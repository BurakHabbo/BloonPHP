<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!gc_enabled())
    gc_enable();

if (!extension_loaded("pthreads"))
    die("Please install pthreads extension !");

if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    die("Please install composer and run 'composer install' !" . PHP_EOL);
}

use Emulator\Emulator;

Emulator::start();
