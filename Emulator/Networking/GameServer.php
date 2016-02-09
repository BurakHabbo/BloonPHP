<?php

namespace Emulator\Networking;

use React\EventLoop\Factory;
use React\Socket\Server;
use Thread;
use Emulator\Emulator;
use Emulator\HabboHotel\GameClients\GameClientManager;
use Emulator\Messages\PacketManager;
use Emulator\Messages\ClientMessage;
use Emulator\Networking\Protocol\HabboEncoding;
use Emulator\Networking\Crypto\RSA;
use Emulator\Networking\Crypto\RSAKey;

require 'Emulator/Networking/Protocol/HabboEncoding.php';
require 'Emulator/Messages/ClientMessage.php';

class GameServer extends Thread {

    private $host;
    private $port;
    private $server;
    private $sockets;
    private $packetManager;
    private $gameClientManager;
    private $logging;
    private $rsaKey;
    public static $rsa;

    public function __construct(string $host, int $port, $logging) {
        $this->host = $host;
        $this->port = $port;
        $this->logging = $logging;
        $this->packetManager = new PacketManager($logging);
        $this->gameClientManager = new GameClientManager();
        $this->rsaKey = new RSAKey();
        self::$rsa = new RSA();
        self::$rsa->setPrivate($this->rsaKey->getN(), $this->rsaKey->getE(), $this->rsaKey->getD());
        $this->server = stream_socket_server("tcp://" . $this->host . ":" . $this->port, $errno, $errorMessage);
        stream_set_blocking($this->server, 0);
    }

    public function run() {
        self::$rsa = new RSA();
        self::$rsa->setPrivate($this->rsaKey->getN(), $this->rsaKey->getE(), $this->rsaKey->getD());
        /* Need some improvement here, I know is weak :p */
        $sockets = array();
        while (true) {
            $read_socks = $sockets;
            $read_socks[] = $this->server;
            if (!stream_select($read_socks, $write, $except, 300000)) {
                die('something went wrong while selecting');
            }

            if (in_array($this->server, $read_socks)) {
                $new_client = stream_socket_accept($this->server);
                stream_set_blocking($new_client, 0);
                if (is_resource($new_client)) {
                    list($ip, $port) = explode(":", stream_socket_get_name($new_client, true));
                    $this->gameClientManager->addClient((int) $new_client, $new_client, $ip, $port);
                    echo 'Connection accepted from ' . stream_socket_get_name($new_client, true) . "\n";
                    $sockets[] = $new_client;
                }
                unset($read_socks[array_search($this->server, $read_socks)]);
            }

            foreach ($read_socks as $sock) {
                $gameClient = $this->gameClientManager->getClient((int) $sock);
                $buffer = fread($sock, 4096);
                if (!$buffer) {
                    unset($sockets[array_search($sock, $sockets)]);
                    $this->gameClientManager->disposeClient((int) $sock);
                    continue;
                }

                if ($buffer == "<policy-file-request/>" . chr(0)) {
                    $gameClient->write('<?xml version="1.0"?><!DOCTYPE cross-domain-policy SYSTEM "/xml/dtds/cross-domain-policy.dtd"><cross-domain-policy><allow-access-from domain="*" to-ports="*" /></cross-domain-policy>' . chr(0));
                    continue;
                }

                if ($gameClient->rc4initialized()) {
                    $buffer = $gameClient->getRc4client()->parse($buffer);
                }

                foreach ($this->bufferParser($buffer) as $packet) {
                    $this->packetManager->handlePacket($gameClient, new ClientMessage($packet));
                }
            }
        }
    }

    public function bufferParser($buffer) {
        $packets = array();
        while (strlen($buffer) > 3) {
            $len = HabboEncoding::decodeByte32($buffer) + 4;
            $packets[] = substr($buffer, 0, $len);
            $buffer = substr($buffer, $len);
        }
        return $packets;
    }

    public static function getRSA() {
        return self::$rsa;
    }

}
