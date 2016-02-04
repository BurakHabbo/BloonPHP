<?php

namespace Emulator\Messages\Incoming\Handshake;

use \Emulator\HabboHotel\GameClients\GameClient;

class ReleaseVersionMessageEvent {

    public function __construct(GameClient $client, ClientMessage $packet) {
        
    }

}
