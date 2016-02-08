<?php

namespace Emulator\HabboHotel\ModTool;

use Emulator\HabboHotel\ModTool\ModToolCategory;
use Emulator\HabboHotel\ModTool\ModToolPreset;
use Emulator\Emulator;
use Ubench;

class ModToolManager {

    private $category;
    private $presets;
    private $tickets;

    public function __construct() {
        $bench = new Ubench();
        $bench->start();

        $this->category = array();
        $this->presets = array();
        $this->tickets = array();
        $this->loadModTool();

        $bench->end();
        Emulator::getLogging()->logStart("ModTool Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    public function loadModTool() {
        unset($this->presets);
        $this->presets = array();
        $this->presets["user"] = array();
        $this->presets["room"] = array();
        $this->loadCategory();
    }

    private function loadCategory() {
        unset($this->category);
        $this->category = array();

        $query = Emulator::getDatabase()->query("SELECT * FROM support_issue_categories;");

        foreach ($query as $category) {
            $this->category[(int) $category->id] = new ModToolCategory($category->name);
            $query2 = Emulator::getDatabase()->query("SELECT * FROM support_issue_presets WHERE category = ?;", array((int) $category->id));

            foreach ($query2 as $preset) {
                $this->category[(int) $category->id]->addPreset(new ModToolPreset($preset));
            }
        }
    }

}
