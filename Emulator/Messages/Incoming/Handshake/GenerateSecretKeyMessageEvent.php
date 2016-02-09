<?php

namespace Emulator\Messages\Incoming\Handshake;

use Emulator\HabboHotel\GameClients\GameClient;
use Emulator\Messages\ClientMessage;
use Emulator\Networking\GameServer;
use Emulator\Messages\Outgoing\Handshake\SecretKeyMessageComposer;

require 'Emulator/Messages/Outgoing/Handshake/SecretKeyMessageComposer.php';

class GenerateSecretKeyMessageEvent {

    public function __construct(GameClient $client, ClientMessage $packet) {
        $client->generateSharedKey(GameServer::getRSA()->verify($packet->readString()));

        $client->sendResponse(new SecretKeyMessageComposer(GameServer::getRSA()->sign($client->getPublicKey())));

        $client->initRC4($client->getSharedKey(true));
    }

}
