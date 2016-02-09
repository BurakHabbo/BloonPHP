<?php

namespace Emulator\HabboHotel\GameClients;

use Emulator\Messages\ServerMessage;
use Emulator\Networking\Crypto\DiffieHellman;
use Threaded;

require 'Emulator/Networking/Crypto/DiffieHellman.php';

class GameClient extends Threaded {

    private $id;
    private $socket;
    private $ip;
    private $port;
    private $habbo;
    private $rc4initialized = false;
    private $build;
    private $diffieHellman;

    public function __construct($id, $socket, $ip, $port) {
        $this->id = $id;
        $this->socket = $socket;
        $this->ip = $ip;
        $this->port = (int) $port;
    }

    public function sendResponse(ServerMessage $message) {
        $this->write($message->get());
    }

    public function sendResponses(array $messages) {
        foreach ($messages as $message) {
            $this->write($message->get());
        }
    }

    public function write($data) {
        fwrite($this->socket, $data, strlen($data));
    }

    public function dispose() {
        fclose($this->socket);

        if (isset($this->habbo)) {
            if ($this->habbo->isOnline()) {
                $this->habbo->disconnect();
            }
        }
    }

    public function initDH() {
        $this->diffieHellman = new DiffieHellman();
        $this->diffieHellman->generateDH();
    }

    public function getPrime() {
        return $this->diffieHellman->getPrime();
    }

    public function getGenerator() {
        return $this->diffieHellman->getGenerator();
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

    function getBuild() {
        return $this->build;
    }

    function setBuild($build) {
        $this->build = $build;
    }

}
