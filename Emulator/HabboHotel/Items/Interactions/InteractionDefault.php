<?php

namespace Emulator\HabboHotel\Items\Interactions;

class InteractionDefault {

    public function __construct($set, $baseItem, $item = null, $extradata = "", $limitedStack = 0, $limitedSells = 0) {
        parent::_construct($set, $baseItem, $item, $extradata, $limitedStack, $limitedSells);
    }

}
