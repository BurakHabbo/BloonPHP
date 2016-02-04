<?php

namespace Emulator\Messages\Outgoing\Handshake;

use Emulator\Messages\ServerMessage;
use Emulator\Messages\Outgoing\ServerPacketHeader;

class InitCryptoMessageComposer extends ServerMessage {

    public function __construct(string $prime, string $generator) {
        parent::__construct(ServerPacketHeader::$InitCryptoMessageComposer);
        $this->appendString($generator);
        $this->appendString($prime);
    }

}
