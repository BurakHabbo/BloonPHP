<?php

namespace Emulator\HabboHotel\Items;

class SoundTrack {

    private $id;
    private $name;
    private $author;
    private $code;
    private $data;
    private $length;

    public function __construct($set) {
        $this->id = (int) $set->id;
        $this->name = $set->name;
        $this->author = $set->author;
        $this->code = $set->code;
        $this->data = isset($set->data) ? $set->data : "";
        $this->length = (int) $set->length;
    }

}
