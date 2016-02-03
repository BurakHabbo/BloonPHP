<?php

namespace Emulator\Core;

use Zend\Config\Reader\Ini as IniReader;
use Emulator\Emulator;

class ConfigurationManager {

    private $values = [];
    public $loaded = false;
    private $path = "config.ini";

    public function __construct(string $path) {
        $this->path = $path;
        $this->reload();
        Emulator::getLogging()->logStart("Configuration Manager -> Loaded!");
    }

    public function reload() {
        if (file_exists($this->path)) {
            //$reader = new IniReader();
            //$this->values = $reader->fromFile($this->path); //NEED FIX
            $this->values = parse_ini_file($this->path);
        } else {
            Emulator::getLogging()->logErrorLine("[CONFIG] Config file not found (" . $this->path . ")");
        }

        if ($this->loaded) {
            $this->loadFromDatabase();
        }
    }

    public function loadFromDatabase() {
        $settings = Emulator::getDatabase()->query("SELECT * FROM emulator_settings;");

        foreach ($settings as $setting) {
            $this->values[$setting->key] = $setting->value;
        }
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