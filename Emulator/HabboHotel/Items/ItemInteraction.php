<?php

namespace Emulator\HabboHotel\Items;

use Emulator\HabboHotel\Users\HabboItem;

class ItemInteraction {

    private $name;
    private $type;

    public function __construct(string $name, $type) {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

}
