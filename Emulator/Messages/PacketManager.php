<?php

namespace Emulator\Messages;

use Emulator\Emulator;
use Emulator\HabboHotel\GameClients\GameClient;
use Emulator\Messages\ClientMessage;
use Emulator\Messages\Incoming\ClientPacketHeader;
use Emulator\Messages\Incoming\Handshake\ReleaseVersionMessageEvent;
use Emulator\Messages\Incoming\Handshake\InitCryptoMessageEvent;

class PacketManager {

    private $incoming;
    private $logging;

    public function __construct($logging) {
        $this->logging = $logging;
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
            $this->logging->logPacketLine("[\033[36mCLIENT\033[0m][" . $packet->getHeader() . "] => " . $this->cleanUp($packet->getFullPacket()));
            new $this->incoming[$packet->getHeader()]($client, $packet);
        } else {
            $this->logging->logPacketLine("[\033[36mCLIENT\033[0m][\033[31mUNDEFINED\033[0m][" . $packet->getHeader() . "] => " . $this->cleanUp($packet->getFullPacket()));
        }
    }

    public function isRegistered(int $header) {
        return isset($this->incoming[$header]);
    }

    private function registerHandshake() {
        $this->registerHandler(ClientPacketHeader::$ReleaseVersionMessageEvent, ReleaseVersionMessageEvent::class);
        $this->registerHandler(ClientPacketHeader::$InitCryptoMessageEvent, InitCryptoMessageEvent::class);
    }

    private function cleanUp($string) {
        for ($i = 0; $i <= 31; $i++) {
            $string = str_replace(chr($i), "[" . $i . "]", $string);
        }

        return $string;
    }

}
