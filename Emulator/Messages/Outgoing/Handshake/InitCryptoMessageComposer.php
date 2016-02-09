<?php

namespace Emulator\Messages\Outgoing\Handshake;

use Emulator\Messages\ServerMessage;
use Emulator\Messages\Outgoing\ServerPacketHeader;

require 'Emulator/Messages/Outgoing/ServerPacketHeader.php';

class InitCryptoMessageComposer extends ServerMessage {

    public function __construct(string $prime, string $generator) {
        parent::__construct(ServerPacketHeader::InitCryptoMessageComposer);
        $this->appendString($prime);
        $this->appendString($generator);
    }

}
