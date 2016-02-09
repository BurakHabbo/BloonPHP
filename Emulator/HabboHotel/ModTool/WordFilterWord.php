<?php

namespace Emulator\HabboHotel\ModTool;

use Emulator\Emulator;

class WordFilterWord {

    private $key;
    private $replacement;
    private $hideMessage;
    private $autoReport;

    public function __construct($set) {
        $this->key = $set->key;
        $this->replacement = $set->replacement;
        $this->hideMessage = (bool) ((int) $set->hide == 1);
        $this->autoReport = (bool) ((int) $set->report == 1);
    }

    public function getKey() {
        return $this->key;
    }

    public function getReplacement() {
        return $this->replacement;
    }

    public function isHideMessage() {
        return $this->hideMessage;
    }

    public function isAutoReport() {
        return $this->autoReport;
    }

}
