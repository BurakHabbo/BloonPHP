<?php

namespace Emulator\HabboHotel\Pets;

class PetCommand {

    private $id;
    private $key;
    private $level;
    private $xp;
    private $energyCost;
    private $happynessCost;

    public function __construct($set) {
        $this->id = (int) $set->command_id;
        $this->key = $set->text;
        $this->level = (int) $set->required_level;
        $this->xp = (int) $set->reward_xp;
        $this->energyCost = (int) $set->cost_energy;
        $this->happynessCost = (int) $set->cost_happyness;
    }

    public function getId() {
        return $this->id;
    }

    public function getKey() {
        return $this->key;
    }

    public function getLevel() {
        return $this->level;
    }

    public function getXp() {
        return $this->xp;
    }

    public function getEnergyCost() {
        return $this->energyCost;
    }

    public function getHappynessCost() {
        return $this->happynessCost;
    }

}
