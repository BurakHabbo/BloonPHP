<?php

namespace Emulator\HabboHotel\Pets;

class PetRace {

    private $race;
    private $colorOne;
    private $colorTwo;
    private $hasColorOne;
    private $hasColorTwo;

    public function __construct($set) {
        $this->race = (int) $set->race;
        $this->colorOne = (int) $set->color_one;
        $this->colorTwo = (int) $set->color_two;
        $this->hasColorOne = (bool) $set->has_color_one == "1";
        $this->hasColorTwo = (bool) $set->has_color_two == "1";
    }

    public function getRace() {
        return $this->race;
    }

    public function getColorOne() {
        return $this->colorOne;
    }

    public function getColorTwo() {
        return $this->colorTwo;
    }

    public function getHasColorOne() {
        return $this->hasColorOne;
    }

    public function getHasColorTwo() {
        return $this->hasColorTwo;
    }

}
