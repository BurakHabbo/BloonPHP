<?php

namespace Emulator\Core;

use Zend\Config\Reader\Ini as IniReader;
use Emulator\Emulator;

class ConfigurationManager {

    private $values = [];
    private $loaded = false;
    private $path = "config.ini";

    public function __construct(string $path) {
        $this->path = $path;
        $this->reload();
    }

    public function reload() {
        if (file_exists($this->path)) {
            //$reader = new IniReader();
            //$this->values = $reader->fromFile($this->path); //NEED FIX
            $this->values = parse_ini_file($this->path);
        } else {
            //better error manager and exception catch here
            die("config file not found");
        }
        //$this->loadFromDatabase(); TO DO
    }

    public function getValue(string $key, string $defaultValue = null) {
        if (!isset($this->values[$key])) {
            Emulator::getLogging()->logErrorLine("[CONFIG] Key not found: " . $key);

            return $defaultValue;
        } else {
            return (string) $this->values[$key];
        }
    }

    public function getBoolean(string $key, bool $defaultValue = false) {
        if (!isset($this->values[$key])) {
            Emulator::getLogging()->logErrorLine("[CONFIG] Key not found: " . $key);

            return $defaultValue;
        } else {
            return (bool) $this->values[$key] == "1" || strtolower($this->values[$key]) == "true" ? true : false;
        }
    }

    public function getInt(string $key, int $defaultValue = 0) {
        if (!isset($this->values[$key])) {
            Emulator::getLogging()->logErrorLine("[CONFIG] Key not found: " . $key);

            return $defaultValue;
        } else {
            return (int) $this->values[$key];
        }
    }

}

?>