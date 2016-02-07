<?php

namespace Emulator\HabboHotel\Catalog\Layouts;

use Emulator\HabboHotel\Catalog\CatalogPage;
use Emulator\Messages\ServerMessage;

class RecyclerPrizesLayout extends CatalogPage {

    public function __construct($set) {
        parent::__construct($set);
    }

    public function serialize(ServerMessage $message) {
        $message->appendString("recycler_prizes");
        $message->appendInt32(3);
        $message->appendString("");
        $message->appendString("");
        $message->appendString("");
        $message->appendInt32(3);
        $message->appendString("");
        $message->appendString("");
        $message->appendString("");
    }

}
