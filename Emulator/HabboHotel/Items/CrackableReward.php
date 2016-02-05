<?php

namespace Emulator\HabboHotel\Items;

class CrackableReward {

    private $itemId;
    private $count;
    private $prizes;
    private $achievementTick;
    private $achievementCracked;

    public function __construct($set) {
        $this->itemId = (int) $set->item_id;
        $this->count = (int) $set->count;
        $this->achievementTick = $set->achievement_tick;
        $this->achievementCracked = $set->achievement_cracked;

        $this->prizes = array();
        foreach (explode(";", str_replace(",", ";", $set->prizes)) as $s) {
            $this->prizes[] = $s;
        }
    }

    public function getRandomReward() {
        return $this->prizes[rand(0, count($this->prizes) - 1)];
    }

}
