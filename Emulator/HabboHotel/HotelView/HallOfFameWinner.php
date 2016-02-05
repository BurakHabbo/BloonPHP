<?php

namespace Emulator\HabboHotel\HotelView;

use Emulator\Emulator;

class HallOfFameWinner {

    private $id;
    private $username;
    private $look;
    private $points;

    public function __construct($set) {
        $this->id = $set->id;
        $this->username = $set->username;
        $this->look = $set->look;
        $this->points = $set->hof_points;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getLook() {
        return $this->look;
    }

    public function getPoints() {
        return $this->points;
    }

    public function compareTo(HallOfFameWinner $winner) {
        return $winner->getPoints() - $this->points;
    }

}
