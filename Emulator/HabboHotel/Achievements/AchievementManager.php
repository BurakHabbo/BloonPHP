<?php

namespace Emulator\HabboHotel\Achievements;

use Emulator\Emulator;
use Ubench;

class AchievementManager {

    private $achievements;

    public function __construct() {
        $bench = new Ubench();
        $bench->start();

        $this->achievements = array();
        $this->reload();

        $bench->end();
        Emulator::getLogging()->logStart("Achievement Manager -> Loaded! (" . $bench->getTime() . ")");
    }

    public function reload() {
        unset($this->achievements);
        $this->achievements = array();

        $query = Emulator::getDatabase()->query("SELECT * FROM achievements;");

        foreach ($query as $achievement) {
            $this->achievements[$achievement->name] = new Achievement($achievement);
        }
    }

}
