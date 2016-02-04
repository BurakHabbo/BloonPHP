<?php

namespace Emulator\Messages;

use Emulator\Messages\ClientMessage;
use Emulator\Messages\Incoming\ClientPacketHeader;
use Emulator\Messages\Incoming\Handshake\ReleaseVersionMessageEvent;
use Emulator\HabboHotel\GameClients\GameClient;

/* Thread don't support namespace autoloading */
require 'Emulator/Messages/Incoming/Handshake/ReleaseVersionMessageEvent.php';

class PacketManager {

    private $incoming;

    public function __construct() {
        $this->incoming = array();
        $this->registerHandshake();
    }

    public function registerHandler(int $header, $handler) {
        $this->incoming[$header] = $handler;
    }

    public function handlePacket(GameClient $client, ClientMessage $packet) {
        if ($client == null) {
            return;
        }

        if ($this->isRegistered($packet->getHeader())) {
            new $this->incoming[$packet->getHeader()]($client, $packet);
        }
    }

    public function isRegistered(int $header) {
        return isset($this->incoming[$header]);
    }

    private function registerHandshake() {
        $this->registerHandler(ClientPacketHeader::$ReleaseVersionMessageEvent, ReleaseVersionMessageEvent::class);
    }

}
