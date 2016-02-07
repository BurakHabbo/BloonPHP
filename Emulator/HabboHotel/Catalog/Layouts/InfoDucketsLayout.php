<?php

namespace Emulator\HabboHotel\Catalog\Layouts;

use Emulator\HabboHotel\Catalog\CatalogPage;
use Emulator\Messages\ServerMessage;

class InfoDucketsLayout extends CatalogPage {

    public function __construct($set) {
        parent::__construct($set);
    }

    public function serialize(ServerMessage $message) {
        $message->appendString("info_duckets");
        $message->appendInt32(1);
        $message->appendString($this->getHeaderImage());
        $message->appendInt32(1);
        $message->appendString($this->getTextOne());
        $message->appendInt32(0);
    }

}
