<?php

namespace Emulator\HabboHotel\GameClients;

use Threaded;

class GameClient extends Threaded {

    private $id;
    private $socket;
    private $ip;
    private $port;
    private $habbo;
    private $rc4initialized = false;

    public function __construct($id, $socket, $ip, $port) {
        $this->id = $id;
        $this->socket = $socket;
        $this->ip = $ip;
        $this->port = (int) $port;
    }

    public function write($data) {
        fwrite($this->socket, $data);
    }

    public function dispose() {
        fclose($this->socket);

        if (isset($this->habbo)) {
            if ($this->habbo->isOnline()) {
                $this->habbo->disconnect();
            }
        }
    }

    public function rc4initialized() {
        return $this->rc4initialized;
    }

    public function enableRC4() {
        $this->rc4initialized = true;
    }

    function getSocket() {
        return $this->socket;
    }

    function getHabbo() {
        return $this->habbo;
    }

    function setHabbo($habbo) {
        $this->habbo = $habbo;
    }

}
