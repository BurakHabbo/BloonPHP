<?php

namespace Emulator\Messages\Incoming\Handshake;

use Emulator\HabboHotel\GameClients\GameClient;
use Emulator\Messages\ClientMessage;
use Emulator\Networking\GameServer;
use Emulator\Messages\Outgoing\Handshake\InitCryptoMessageComposer;

class InitCryptoMessageEvent {

    public function __construct(GameClient $client, ClientMessage $packet) {
        $client->initDH();
        $client->sendResponse(new InitCryptoMessageComposer(GameServer::getRSA()->sign($client->getPrime()), GameServer::getRSA()->sign($client->getGenerator())));
    }

}
