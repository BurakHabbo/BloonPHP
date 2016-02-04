<?php

namespace Emulator\Messages\Incoming\Handshake;

use Emulator\HabboHotel\GameClients\GameClient;
use Emulator\Messages\ClientMessage;

class ReleaseVersionMessageEvent {

    public function __construct(GameClient $client, ClientMessage $packet) {
        print($packet->readString() . PHP_EOL);
    }

}
