<?php

namespace Emulator\HabboHotel\ModTool;

use Emulator\HabboHotel\ModTool\ModToolPreset;

class ModToolCategory {

    private $name;
    private $presets;

    public function __construct(string $name) {
        $this->name = $name;
        $this->presets = array();
    }

    public function getName() {
        return $this->name;
    }

    public function getPresets() {
        return $this->presets;
    }

    public function addPreset(ModToolPreset $preset) {
        $this->presets[] = $preset;
    }

}
