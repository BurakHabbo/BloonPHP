<?php

namespace Emulator\Messages;

use Emulator\Messages\Incoming\ClientPacketHeader;
use Emulator\Messages\Incoming\Handshake\ReleaseVersionMessageEvent;

class PacketManager {

    private $incoming;

    public function __construct() {
        $this->incoming = array();
        $this->registerHandshake();
    }

    public function registerHandler(int $header, $handler) {
        $this->incoming[$header] = $handler;
    }

    public function isRegistered(int $header) {
        return isset($this->incoming[$header]);
    }

    private function registerHandshake() {
        $this->registerHandler(ClientPacketHeader::$ReleaseVersionMessageEvent, ReleaseVersionMessageEvent::class);
    }

}
