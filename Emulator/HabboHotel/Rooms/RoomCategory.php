<?php

namespace Emulator\HabboHotel\Rooms;

class RoomCategory {

    private $id;
    private $minRank;
    private $caption;
    private $canTrade;

    public function __construct($set) {
        $this->id = (int) $set->id;
        $this->minRank = (int) $set->min_rank;
        $this->caption = $set->caption;
        $this->canTrade = (bool) $set->can_trade == 1;
    }

    public function getId() {
        return $this->id;
    }

    public function getMinRank() {
        return $this->minRank;
    }

    public function getCaption() {
        return $this->caption;
    }

    public function isCanTrade() {
        return $this->canTrade;
    }

}
