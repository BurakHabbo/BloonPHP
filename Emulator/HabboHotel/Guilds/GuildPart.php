<?php

namespace Emulator\HabboHotel\Guilds;

class GuildPart {

    private $id;
    private $valueA;
    private $valueB;

    public function __construct($set) {
        $this->id = $set->id;
        $this->valueA = $set->firstvalue;
        $this->valueB = $set->secondvalue;
    }

    public function getId() {
        return $this->id;
    }

    public function getValueA() {
        return $this->valueA;
    }

    public function getValueB() {
        return $this->valueB;
    }

}
