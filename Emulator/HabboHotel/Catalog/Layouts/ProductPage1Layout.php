<?php

namespace Emulator\HabboHotel\Catalog\Layouts;

use Emulator\HabboHotel\Catalog\CatalogPage;
use Emulator\Messages\ServerMessage;

class ProductPage1Layout extends CatalogPage {

    public function __construct($set) {
        parent::__construct($set);
    }

    public function serialize(ServerMessage $message) {
        $message->appendString("productpage1");
        $message->appendInt32(2);
        $message->appendString($this->getHeaderImage());
        $message->appendString($this->getTeaserImage());
        $message->appendInt32(4);
        $message->appendString($this->getTextOne());
        $message->appendString($this->getTextTwo());
        $message->appendString($this->getTextDetails());
        $message->appendString($this->getTextTeaser());
    }

}
