<?php

namespace Emulator\HabboHotel\ModTool;

use Emulator\HabboHotel\ModTool\ModToolCategory;
use Emulator\HabboHotel\ModTool\ModToolPreset;
use Emulator\HabboHotel\ModTool\ModToolIssue;
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
        $this->loadPresets();
        $this->loadTickets();

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

    private function loadPresets() {
        $query = Emulator::getDatabase()->query("SELECT * FROM support_presets;");

        foreach ($query as $preset) {
            $this->presets[$preset->type][] = $preset->preset;
        }
    }

    private function loadTickets() {
        $query = Emulator::getDatabase()->query("SELECT S.username as sender_username, R.username AS reported_username, M.username as mod_username, support_tickets.* FROM support_tickets INNER JOIN users as S ON S.id = sender_id INNER JOIN users AS R ON R.id = reported_id INNER JOIN users AS M ON M.id = mod_id WHERE state != 0;");

        foreach ($query as $ticket) {
            $this->tickets[(int) $ticket->id] = new ModToolIssue($ticket);
        }
    }

}
