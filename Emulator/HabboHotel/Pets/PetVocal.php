<?php

namespace Emulator\HabboHotel\Pets;

class PetVocal {

    private $message;

    public function __construct(string $message) {
        $this->message = $message;
    }

    public function getMessage() {
        return $this->message;
    }

}
