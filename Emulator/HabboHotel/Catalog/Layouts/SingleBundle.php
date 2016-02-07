<?php

namespace Emulator\HabboHotel\Catalog\Layouts;

use Emulator\HabboHotel\Catalog\CatalogPage;
use Emulator\Messages\ServerMessage;

class SingleBundle extends CatalogPage {

    public function __construct($set) {
        parent::__construct($set);
    }

    public function serialize(ServerMessage $message) {
        $message->appendString("single_bundle");
        $message->appendInt32(3);
        $message->appendString($this->getHeaderImage());
        $message->appendString($this->getTeaserImage());
        $message->appendString("");
        $message->appendInt32(4);
        $message->appendString($this->getTextOne());
        $message->appendString($this->getTextDetails());
        $message->appendString($this->getTextTeaser());
        $message->appendString($this->getTextTwo());
    }

}
