<?php

namespace Emulator\HabboHotel\Achievements;

use Emulator\HabboHotel\Achievements\AchievementCategories;
use Emulator\HabboHotel\Achievements\AchievementLevel;

class Achievement {

    private $id;
    private $name;
    private $category;
    private $levels;

    public function __construct($set) {
        $this->id = (int) $set->id;
        $this->name = $set->name;
        $this->category = new AchievementCategories(strtoupper($set->category));
        $this->levels = array();
        $this->addLevel(new AchievementLevel($set));
    }

    public function addLevel(AchievementLevel $level) {
        $this->levels[$level->getLevel()] = $level;
    }

}
