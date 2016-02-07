<?php

namespace Emulator\HabboHotel\Catalog\Layouts;

use Emulator\HabboHotel\Catalog\CatalogPage;
use Emulator\Messages\ServerMessage;

class ClubBuyLayout extends CatalogPage {

    public function __construct($set) {
        parent::__construct($set);
    }

    public function serialize(ServerMessage $message) {
        $message->appendString("vip_buy");
        $message->appendInt32(2);
        $message->appendString($this->getHeaderImage());
        $message->appendString($this->getTeaserImage());
        $message->appendInt32(0);
    }

}
