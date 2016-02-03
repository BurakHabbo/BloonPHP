<?php

namespace Emulator\Core;

use Emulator\Emulator;

class TextsManager {

    private $texts = [];

    public function __construct() {
        $this->reload();
        Emulator::getLogging()->logStart("Texts Manager -> Loaded!");
    }

    public function reload() {
        $texts = Emulator::getDatabase()->query("SELECT * FROM emulator_texts;");

        foreach ($texts as $text) {
            $this->texts[$text->key] = $text->value;
        }
    }

    public function getValue(string $key, string $defaultValue = null) {
        if (!isset($this->texts[$key])) {
            Emulator::getLogging()->logErrorLine("[TEXTS] Text key not found: " . $key);

            return $defaultValue;
        } else {
            return (string) $this->texts[$key];
        }
    }

    public function getBoolean(string $key, bool $defaultValue = false) {
        if (!isset($this->texts[$key])) {
            Emulator::getLogging()->logErrorLine("[TEXTS] Text key not found: " . $key);

            return $defaultValue;
        } else {
            return (bool) $this->texts[$key] == "1" || strtolower($this->texts[$key]) == "true" ? true : false;
        }
    }

    public function getInt(string $key, int $defaultValue = 0) {
        if (!isset($this->texts[$key])) {
            Emulator::getLogging()->logErrorLine("[[TEXTS] Text key not found: " . $key);

            return $defaultValue;
        } else {
            return (int) $this->texts[$key];
        }
    }

}
