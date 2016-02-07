<?php

namespace Emulator\HabboHotel\Catalog\Layouts;

use Emulator\HabboHotel\Catalog\CatalogPage;
use Emulator\Messages\ServerMessage;

class InfoRentablesLayout extends CatalogPage {

    public function __construct($set) {
        parent::__construct($set);
    }

    public function serialize(ServerMessage $message) {
        $data = explode("\\|\\|", $this->getTextOne());
        $message->appendString("info_rentables");
        $message->appendInt32(1);
        $message->appendString($this->getHeaderImage());
        $message->appendInt32(count($data));
        foreach ($data as $s) {
            $message->appendString($s);
        }
        $message->appendInt32(0);
    }

}
