<?php

namespace Emulator\HabboHotel\GameClients;

use Emulator\Messages\ServerMessage;
use Emulator\Networking\Crypto\DiffieHellman;
use Emulator\Networking\Crypto\RC4;
use Emulator\HabboHotel\Users\Habbo;
use Emulator\Emulator;
use Threaded;

require 'Emulator/Networking/Crypto/DiffieHellman.php';
require 'Emulator/Networking/Crypto/RC4.php';

class GameClient extends Threaded {

    private $id;
    private $socket;
    private $ip;
    private $port;
    private $habbo;
    private $build;
    private $diffieHellman;
    private $logger;
    private $rc4client;
    private $rc4server;
    private $rc4initialized = false;

    public function __construct($id, $socket, $ip, $port, $logger) {
        $this->id = $id;
        $this->socket = $socket;
        $this->ip = $ip;
        $this->port = (int) $port;
        $this->logger = $logger;
    }

    public function sendResponse(ServerMessage $message) {
        $this->logger->logPacketLine("[\033[33mSERVER\033[0m][" . $message->getHeader() . "] => " . $this->cleanUp($message->get()));
        $this->write($message->get());
    }

    public function sendResponses(array $messages) {
        foreach ($messages as $message) {
            $this->logger->logPacketLine("[\033[33mSERVER\033[0m][" . $message->getHeader() . "] => " . $this->cleanUp($message->get()));
            $this->write($message->get());
        }
    }

    public function write(string $data) {
        if ($this->rc4initialized) {
            $data = $this->rc4server->parse($data);
        }
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

    private function cleanUp($string) {
        for ($i = 0; $i <= 31; $i++) {
            $string = str_replace(chr($i), "[" . $i . "]", $string);
        }

        return $string;
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

    public function generateSharedKey(string $publicClientKey) {
        $this->diffieHellman->generateSharedKey($publicClientKey);
    }

    public function getSharedKey(bool $bytearray = false) {
        return $this->diffieHellman->getSharedKey($bytearray);
    }

    public function initRC4(array $sharedKey) {
        $this->rc4client = new RC4();
        $this->rc4client->init($sharedKey);
        $this->rc4server = new RC4();
        $this->rc4server->init($sharedKey);
        $this->rc4initialized = true;
    }

    public function getPublicKey(bool $bytearray = false) {
        return $this->diffieHellman->getPublicKey($bytearray);
    }

    public function rc4initialized() {
        return $this->rc4initialized;
    }

    public function getRc4client() {
        return $this->rc4client;
    }

    public function getRc4server() {
        return $this->rc4server;
    }

    public function getSocket() {
        return $this->socket;
    }

    public function getHabbo() {
        return $this->habbo;
    }

    public function setHabbo(Habbo $habbo) {
        $this->habbo = $habbo;
    }

    public function getBuild() {
        return $this->build;
    }

    public function setBuild(string $build) {
        $this->build = $build;
    }

}
