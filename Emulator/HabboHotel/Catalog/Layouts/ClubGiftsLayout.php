<?php

namespace Emulator\HabboHotel\Catalog\Layouts;

use Emulator\HabboHotel\Catalog\CatalogPage;
use Emulator\Messages\ServerMessage;

class ClubGiftsLayout extends CatalogPage {

    public function __construct($set) {
        parent::__construct($set);
    }

    public function serialize(ServerMessage $message) {
        $message->appendString("club_gifts");
        $message->appendInt32(1);
        $message->appendString($this->getHeaderImage());
        $message->appendInt32(1);
        $message->appendString($this->getTextOne());
    }

}
