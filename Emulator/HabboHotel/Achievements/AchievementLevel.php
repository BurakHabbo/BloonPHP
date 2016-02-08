<?php

namespace Emulator\HabboHotel\Achievements;

class AchievementLevel {

    private $level;
    private $pixels;
    private $points;
    private $progress;

    public function __construct($set) {
        $this->level = (int) $set->level;
        $this->pixels = (int) $set->pixels;
        $this->points = (int) $set->points;
        $this->progress = (int) $set->progress_needed;
    }

    public function getLevel() {
        return $this->level;
    }

    public function getPixels() {
        return $this->pixels;
    }

    public function getPoints() {
        return $this->points;
    }

    public function getProgress() {
        return $this->progress;
    }

}
