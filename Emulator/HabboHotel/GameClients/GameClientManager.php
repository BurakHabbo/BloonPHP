<?php

namespace Emulator\HabboHotel\GameClients;

require 'Emulator/HabboHotel/GameClients/GameClient.php';

use Emulator\HabboHotel\GameClients\GameClient;
use Threaded;

class GameClientManager extends Threaded {

    private $clients;

    public function __construct() {
        $this->clients = array();
    }

    public function getSessions() {
        return $this->clients;
    }

    public function containsClient($key) {
        return isset($this->clients[$key]);
    }

    public function getClient($key) {
        if (isset($this->clients[$key])) {
            return $this->clients[$key];
        }
        return null;
    }

    public function addClient($id, $socket, $ip, $port) {
        $this->clients[$id] = new GameClient($id, $socket, $ip, $port);
        return true;
    }

    public function disposeClient($id) {
        $client = $this->getClient($id);

        if ($client != null) {
            $client->dispose();
        }

        unset($this->clients[$id]);
    }

}
