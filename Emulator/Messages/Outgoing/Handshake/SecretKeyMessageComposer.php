<?php

namespace Emulator\Messages\Outgoing\Handshake;

use Emulator\Messages\ServerMessage;
use Emulator\Messages\Outgoing\ServerPacketHeader;

class SecretKeyMessageComposer extends ServerMessage {

    public function __construct(string $publicKey) {
        parent::__construct(ServerPacketHeader::SecretKeyMessageComposer);
        $this->appendString($publicKey);
        $this->appendBoolean(true);
    }

}
