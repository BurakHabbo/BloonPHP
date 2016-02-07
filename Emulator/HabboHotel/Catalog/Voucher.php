<?php

namespace Emulator\HabboHotel\Catalog;

class Voucher {

    private $id;
    private $code;
    private $credits;
    private $points;
    private $pointsType;

    public function __construct($set) {
        $this->id = (int) $set->id;
        $this->code = $set->code;
        $this->credits = (int) $set->credits;
        $this->points = (int) $set->points;
        $this->pointsType = (int) $set->points_type;
    }

    public function getId() {
        return $this->id;
    }

    public function getCode() {
        return $this->code;
    }

    public function getCredits() {
        return $this->credits;
    }

    public function getPoints() {
        return $this->points;
    }

    public function getPointsType() {
        return $this->pointsType;
    }

}
